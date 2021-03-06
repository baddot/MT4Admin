<?php

include_once('simple_html_dom.php');

class Shop
{
        private $key = "cdfb231edbe5d2872ddd2e044c92e13d"; // 사용자가 발급받은 오픈API 키 
        private $searchUrl = "http://openapi.naver.com/search"; // 오픈API 호출URL
        private $target = "local";
        private $sort = "vote";
        private $searchlocalUrl = 'http://map.naver.com/search2/local.nhn';
		private $strDetailPageUrl = 'http://map.naver.com/local/siteview.nhn?code=';
		
        /**
         * API 결과를 받아오기 위하여 오픈API 서버에 Request 를 하고 결과를 XML Object 로 반환하는 메소드
         * @return object
         */
        private function query($query)
        {
                $url = sprintf("%s?query=%s&target=%s&sort=%s&key=%s", $this->searchUrl, urlencode($query), $this->target, $this->sort, $this->key);
                $data =file_get_contents($url);
                $xml = simplexml_load_string($data);
                
                return $xml;
        }
        
        // s20089001 -> 20089001
		private function convShopID($id) {
			$number = substr($id, 1);
			return $number;
		}

        /**
         * API의 결과를 Json 으로 encode 하려 반환하는 메소드
         * XML을 직접 parsing 하지 않고 json으로 변환하여 반환한다. 
         */
        public function getShopSearch($query) {     
        	$xml = $this->query($query);
            $result = json_encode($xml);

            return $result; 
        }
        
        public function writeShopArrayFromNavor($query, $pageNum, $category) {
        	
        	set_time_limit(0);
        	
        	$retData = Array();
        	
        	$data = $this->getShopBaseInfo($query, $pageNum);
        	
        	$retData['result'] = Array();
        	$retData['result']['length'] = 0;
        	$retData['result']['query'] = $query;
        	$retData['result']['page'] = (int)$pageNum;
        	$retData['result']['category'] = $category;
        	
        	if($data == null) {
        		$retData['msg'] = 'data is null';
        		$retData['code'] = -1;
        		echo json_encode($retData);
                return;
        	}
        	
        	$dataDictionary =  json_decode($data, true);
        	$result = $dataDictionary['result'];

        	if(array_key_exists('result', $dataDictionary) == false) {
        		$retData['msg'] = 'data is not a right array'.$data;
        		$retData['code'] = -1;

                echo json_encode($retData);
                return;
        	}
        	
		    $itemLength = 0;
		    if($result['totalCount'] > 0) {                 
				$itemLength = count($result['site']['list']);
	            for($i = 0; $i < $itemLength ; $i++){
	                    $item = $result['site']['list'][$i];
	                    $id = $this->convShopID($item['id']);
	                   	$url = $this->strDetailPageUrl.$id;
	                   	
	                   	$detailData = $this->getShopDetailInfo($url);
	                   	
	                   	if($detailData != null) {
	                   		$item['detail'] = $detailData;
	                   	} 	                   	
	                   	
	                   	$item['categoryString'] = $category;
	                   	
	                   	$this->writeItemIntoDB($item);
	            }
	        }
	        
	        $retData['msg'] = 'success';
	        $retData['code'] = 0;
	        $retData['result'] = Array();
	        $retData['result']['length'] = $itemLength;
	        $retData['result']['query'] = $query;
	        $retData['result']['page'] = (int)$pageNum;
	        $retData['result']['category'] = $category;
	        echo json_encode($retData);
        }
        
        public function getShopBaseInfo($query, $pageNum) {
        	$data = array('sm' => 'hty', 
        			      'isFirstSearch' => 'true', 
        			      'menu' => 'location', 
        			      'query' => $query,
        				  'page' => $pageNum
        	);
        	
        	// use key 'http' even if you send the request to https://...
        	$options = array(
        			'http' => array(
        					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        					'method'  => 'POST',
        					'content' => http_build_query($data),
        			),
        	);
        	$context  = stream_context_create($options);
        	$result = file_get_contents($this->searchlocalUrl, false, $context);
        	return $result;
        }
        
        public function getShopDetailInfo($url) {

        	$result = array();
        	
        	$html = file_get_html($url);
        	
        	if($html == null) {
        		return;
        	}

			$jsonString = null;
			foreach($html->find('script[type="text/javascript"]') as $scripHtml) {
				$content = $scripHtml->innertext;
				
				$pos = strpos($content, "siteview ="); 
				if($pos !== false) {
					
					$pos = $pos + strlen('siteview =');
					$endIdx = strpos($content, "};", $pos);
					
					$jsonString = substr($content, $pos , ($endIdx-$pos) + 1);
					break;
				}
				
			}
			
			if($jsonString == null) {
				return;
			}
		
			$resultData = json_decode($jsonString, true);
			
			$time = "";
			$restTime = "";
			if(array_key_exists ('bizHours', $resultData) == true) {
				if( array_key_exists ('bizHourList', $resultData['bizHours']) == true) {
					$timeArray = $resultData['bizHours']['bizHourList'];
					$cnt = count($timeArray);
					
					for($i = 0; $i < $cnt; $i++) {
						$timeDictionary = $timeArray[$i];
						
						$time = $time.$timeDictionary['type'].' '.$timeDictionary['startTime'].'~'.$timeDictionary['endTime'].' ';
						$restTime = $restTime.$timeDictionary['description'].' ';
					}
					
				}
			}
			
			$parkable = 'N';
			if(array_key_exists ('options', $resultData) == true) {
				if( array_key_exists ('optionList', $resultData['options']) == true) {
					$optionArray = $resultData['options']['optionList'];
					$cnt = count($optionArray);
						
					for($i = 0; $i < $cnt; $i++) {
						$optionDictionary = $optionArray[$i];
						
						if(strcmp($optionDictionary['name'], '주차') == 0) {
							$parkable = 'Y';
							break;
						}
					}
				}
			}
			
			$arrProduct = Array();
			if(array_key_exists ('menus', $resultData) == true) {
				if( array_key_exists ('menuList', $resultData['menus']) == true) {
					$arrProduct = $resultData['menus']['menuList'];
				}
			}
			
			$arrImage = Array();
			$isExist = false;
			if(array_key_exists ('imagesForMobileWeb', $resultData) == true) {
				if( array_key_exists ('cpImageList', $resultData['imagesForMobileWeb']) == true) {
					$arrImage = $resultData['imagesForMobileWeb']['cpImageList'];
					$isExist = true;
				}
			}
			if($isExist == false) {
				if(array_key_exists ('images', $resultData) == true) {
					if( array_key_exists ('imageList', $resultData['images']) == true) {
						$arrImage = $resultData['images']['imageList'];
						$isExist = true;
					}
				}
			}
			
			$description = "";
			$road = "";
			if(array_key_exists ('summary', $resultData) == true) {
				if(array_key_exists ('detailedDescription', $resultData['summary']) == true) {
					$description = $resultData['summary']['detailedDescription'];
				}
				else if(array_key_exists ('description', $resultData['summary']) == true) {
					$description = $resultData['summary']['description'];
				}
				
				if(array_key_exists ('road', $resultData['summary']) == true) {
					$road = $resultData['summary']['road'];
				}
				
				if(array_key_exists ('category', $resultData['summary']) == true) {
					$category = $resultData['summary']['category'];
				}
			}
			
			$arrPriceImage = Array();
			if(array_key_exists ('menuImages', $resultData) == true) {
				if( array_key_exists ('menuImageList', $resultData['menuImages']) == true) {
					$arrPriceImage = $resultData['menuImages']['menuImageList'];
				}
			}
			
			$result['time'] = $time;
			$result['rest_time'] = $restTime;
			$result['parkable'] = $parkable;
			$result['product_list'] = $arrProduct;
			$result['image_list'] = $arrImage;
			$result['description'] = $description;
			$result['road'] = $road;
			$result['category'] = $category;
			$result['price_image_list'] = $arrPriceImage;
			
        	return $result;
        }
         
		public function writeItemIntoDB($data) {
			
			if(true) {
/*				if (strcmp($data['categoryString'], '미용실') == 0 && strpos($data['detail']['category'], '미용') !== FALSE) {
					$shopCategoryID  = 2;
				} else if(strcmp($data['categoryString'], '네일샵') == 0 && strpos($data['detail']['category'], '네일') !== FALSE) {
					$shopCategoryID  = 1;
				} else 
				if(strcmp($data['categoryString'], '속눈썹연장샵') == 0 && strpos($data['detail']['category'], '속눈썹') !== FALSE) {
					$shopCategoryID  = 15;
				} else if(strcmp($data['categoryString'], '왁싱샵') == 0 && strpos($data['detail']['category'], '피부,체형관리') !== FALSE) {
					$shopCategoryID  = 16;
				} else if(strcmp($data['categoryString'], '피부샵') == 0 && strpos($data['detail']['category'], '피부') !== FALSE) {
					$shopCategoryID  = 17;
				} else if(strcmp($data['categoryString'], '마사지샵') == 0 && strpos($data['detail']['category'], '마사지') !== FALSE) {
					$shopCategoryID  = 18;
				} */
				if(strcmp($data['categoryString'], '반영구화장') == 0 && strpos($data['detail']['category'], '반영구화장') !== FALSE) {
					$shopCategoryID  = 19;
				} else if(strcmp($data['categoryString'], '타투') == 0 && strpos($data['detail']['category'], '문신,피어싱') !== FALSE) {
					$shopCategoryID  = 20;
				} else return;
			}
				
			$servername = "localhost";
			$username = "mimishop1";
			$password = "mimishop1004";
			$dbname = "mimishop1";
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if (mysqli_connect_error()) {
		    	echo ('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
                return;
			}

            mysqli_query($conn, "set session character_set_connection=utf8;");
            mysqli_query($conn, "set session character_set_results=utf8;");
            mysqli_query($conn, "set session character_set_client=utf8;");
			
			$shopName = $data['name'];
			$shopName = str_replace ("'", "\'", $shopName);//addslashes stripslashes
			$shopAddress = $data['address'];
			$shopPhonenumber = $data['tel'];
			$shopLatitude = $data['y'];
			$shopLongtitude = $data['x'];
			
			$shopAddress = str_replace("\\","\\\\",$shopAddress);
			$shopAddress = str_replace("\"","\\\"",$shopAddress);
			$shopAddress = str_replace("'","\'",$shopAddress);
			

			
			$sql = "SELECT id from tb_shop where STRCMP(shopName, '".$shopName."') = 0 AND STRCMP(shopAddress,'".$shopAddress."') = 0 "."AND shopLongtitude = ".$shopLongtitude." AND shopLatitude = ".$shopLatitude." AND shopCategoryID = ".$shopCategoryID;
			$modify = false;
			
			if ($result = $conn->query($sql)) {
				$row = $result->fetch_object();
				
				if($row != null) {
					$modify = true;
					$shopID =  $row->id;
				}
				
				$result->close();
			}
			

			
			$detailExist = false;
			if(array_key_exists ('detail', $data) == true) {
				if(is_array($data['detail']) == true) {
					$detailExist = true;
				}
			}

			if($detailExist == false || array_key_exists ('time', $data['detail']) == false) {
				$shopOpenTimeStr = "";
			}
			else {
				$shopOpenTimeStr = $data['detail']['time'];
			}
			
			// $str = iconv("EUC-KR", "UTF-8", $str);EUC-KR -> UTF-8
			if($detailExist == false || array_key_exists ('rest_time', $data['detail']) == false) {
				$shopRestTimeStr = "";
			}
			else {
				$shopRestTimeStr = $data['detail']['rest_time'];
			}
			
			if($detailExist == false || array_key_exists ('rest_time', $data['detail']) == false) {
				$shopParkable = "N";
			}
			else {
				$shopParkable = $data['detail']['parkable'];
			}
			
			$shopImgID = null;
			if($detailExist == false || array_key_exists ('image_list', $data['detail']) == false) {
				$shopImageIDArrayStr = "";
			}
			else {
				$imageList = $data['detail']['image_list'];
				$arrImageID = Array();
				$cnt = count($imageList); 
				if($cnt >= 1) {
					for($i = 0; $i < $cnt; $i++) {
						$image = $imageList[$i];
						$url = $image['url'];
						$sql = "SELECT id from tb_image where imageURL='".$url."'";
						$exist = false;
						if ($result = $conn->query($sql)) {
							$row = $result->fetch_object();
							if($row != null) {
								$exist = true;
								array_push($arrImageID, $row->id);
							}
							$result->close();
						}
						
						if($exist == false) {
							$sql = "INSERT INTO tb_image (imageURL) VALUES('".$url."')";
							$exist = false;

							if ($conn->query($sql) == FALSE) {
								echo ( "Error: " . $sql . "<br>" . $conn->error);
                                return;
							}
							
							$sql = "SELECT id from tb_image where imageURL='".$url."'";
							if ($result = $conn->query($sql)) {
								$row = $result->fetch_object();
								if($row != null) {
									array_push($arrImageID,  $row->id);
								}

								$result->close();
							}
						}
					}
					$shopImgID = $arrImageID[0];
				}
				$shopImageIDArrayStr = json_encode($arrImageID);
			}
			
			$shopOwnerID = 0; // admin
			$shopDescriptionString = "";
			if($detailExist == false || array_key_exists ('description', $data['detail']) == false) {
				$shopDescriptionString = "";
			}
			else {
				if($data['detail']['description'] != null) {
					$shopDescriptionString = $data['detail']['description'] ;
					$shopDescriptionString = str_replace ("'", "\'", $shopDescriptionString);//addslashes stripslashes
				}
			}
			
			$shopRoadString = "";
			
			if($detailExist == false || array_key_exists ('road', $data['detail']) == false) {
				$shopRoadString = "";
			}
			else {
				if($data['detail']['road'] != null) {
					$shopRoadString = $data['detail']['road'] ;
					$shopRoadString = str_replace ("'", "\'", $shopRoadString);//addslashes stripslashes
				}
			}
			
			$shopPriceImageIDStr = "";
			if($detailExist == false || array_key_exists ('price_image_list', $data['detail']) == false) {
				$shopPriceImageIDStr = "";
			}
			else {
				$imageList = $data['detail']['price_image_list'];
				$arrImageID = Array();
				$cnt = count($imageList);
				if($cnt >= 1) {
					for($i = 0; $i < $cnt; $i++) {
						$image = $imageList[$i];
						$url = $image['imageUrl'];
						$sql = "SELECT id from tb_image where imageURL='".$url."'";
						$exist = false;
						if ($result = $conn->query($sql)) {
							$row = $result->fetch_object();
							if($row != null) {
								$exist = true;
								array_push($arrImageID, $row->id);
							}
							$result->close();
						}
			
						if($exist == false) {
							$sql = "INSERT INTO tb_image (imageURL) VALUES('".$url."')";
							$exist = false;
			
							if ($conn->query($sql) == FALSE) {
								echo ( "Error: " . $sql . "<br>" . $conn->error);
                                return;
							}
								
							$sql = "SELECT id from tb_image where imageURL='".$url."'";
							if ($result = $conn->query($sql)) {
								$row = $result->fetch_object();
								if($row != null) {
									array_push($arrImageID,  $row->id);
								}
			
								$result->close();
							}
						}
					}
				}
				$shopPriceImageIDStr = json_encode($arrImageID);
			}
			
			$shopRoadString = str_replace("\\","\\\\",$shopRoadString);
			$shopRoadString = str_replace("\"","\\\"",$shopRoadString);
			$shopRoadString = str_replace("'","\'",$shopRoadString);
			
			$shopImageIDArrayStr = str_replace("\\","\\\\",$shopImageIDArrayStr);
			$shopImageIDArrayStr = str_replace("\"","\\\"",$shopImageIDArrayStr);
			$shopImageIDArrayStr = str_replace("'","\'",$shopImageIDArrayStr);
				
			$sql = "INSERT INTO tb_shop (shopName, shopAddress, shopPhonenumber, shopLatitude,
						shopLongtitude, shopParkable, shopOwnerID, shopOpenTimeString, shopRestTimeString, 
					    shopImgIDArrayString, shopDescriptionString, shopRoad, shopCategoryID,shopPriceImgIDArrayString, shopVisibility)
					 	VALUES ('"
								.$shopName."',\""
								.$shopAddress."\",'"
								.$shopPhonenumber."','"
								.$shopLatitude."','"
								.$shopLongtitude."','"
								.$shopParkable."','"
								.$shopOwnerID."','"
								.$shopOpenTimeStr."','"
								.$shopRestTimeStr."',\""
								.$shopImageIDArrayStr."\",'"
								.$shopDescriptionString."',\""
								.$shopRoadString."\",'"
								.$shopCategoryID."','"
								.$shopPriceImageIDStr."', 4)";
			
			
			
			if($modify == true) {
				$sql = "UPDATE tb_shop SET "
								."shopName='".$shopName."',"
								."shopAddress=\"".$shopAddress."\","
								."shopPhonenumber='".$shopPhonenumber."',"
								."shopLatitude='".$shopLatitude."',"
								."shopLongtitude='".$shopLongtitude."',"
								."shopParkable='".$shopParkable."',"
								."shopOpenTimeString='".$shopOpenTimeStr."',"
								."shopRestTimeString='".$shopRestTimeStr."',"
								."shopRoad=\"".$shopRoadString."\","
								."shopPriceImgIDArrayString='".$shopPriceImageIDStr."',"
								."shopImgIDArrayString=\"".$shopImageIDArrayStr."\","
								."shopDescriptionString='".$shopDescriptionString."',"
								."shopCategoryID='".$shopCategoryID."'"
								." where id='".$shopID."'";
			}
			
			if ($conn->query($sql) == FALSE) {
				echo ( "Error: " . $sql . "<br>" . $conn->error);
                return;
			}
			
			if($modify == false) {
				$sql = "SELECT id from tb_shop where STRCMP(shopName, '".$shopName."') = 0 AND STRCMP(shopAddress,'".$shopAddress."') = 0";
				
				$isExist = false;
				if ($result = $conn->query($sql)) {
					$row = $result->fetch_object();
					
					if($row != null) {
						$shopID =   $row->id;
						$isExist = true;
					}
					
					$result->close();
				}
				
				if($isExist == false){
					$shopID = -1;
					echo ( "Error: " . $sql . "<br>" . $conn->error);
                    return;
				}
			}
			
			if($detailExist == false || $shopID == -1 || array_key_exists ('product_list', $data['detail']) == false) {
				$shopProductIDArrayStr = "";
			} 
			else {
				$productList = $data['detail']['product_list'];
				$arrProductID = Array();
				$cnt = count($productList); 
				if($cnt >= 1) {
					for($i = 0; $i < $cnt; $i++) {
						$product = $productList[$i];
						$productName = $product['name'];
						$productName = str_replace ("'", "\'", $productName);//addslashes stripslashes
						
						$productPrice = $product['price'];
						if(false) {
							$productPrice = mb_substr($productPrice, 0, (strlen($productPrice) - 3), 'UTF-8'); // remove '원'
							$productPrice = str_replace (",", "", $productPrice);
						}
						
						$sql = "SELECT id from tb_product where "
											."productName='".$productName
											."' AND productShopID='".$shopID."'";
						$exist = false;
						if ($result = $conn->query($sql)) {
							$row = $result->fetch_object();
							if($row != null) {
								$exist = true;
								$productID =   $row->id;
								array_push($arrProductID, $productID);
							}
							
							$result->close();
						}
						
						if($exist == false) {
							$sql = "INSERT INTO tb_product (productName, productPrice, productShopID) VALUES('"
									.$productName."','"
									.$productPrice."','".$shopID."')";
						}
						else {
							$sql = "UPDATE tb_product SET productPrice='".$productPrice."'"." where id='".$productID."'";
						}
							
						if ($conn->query($sql) == FALSE) {
							echo ( "Error: " . $sql . "<br>" . $conn->error);
                            return;
						}

						if($exist == false) {
							$sql = "SELECT id from tb_product where "
											."productName='".$productName
											."' AND productShopID='".$shopID."'";
							
							if ($result = $conn->query($sql)) {
								$row = $result->fetch_object();
								if($row != null) {
									array_push($arrProductID, $row->id);
								}

								$result->close();
							}
						}
					}
				}
				$shopProductIDArrayStr = json_encode($arrProductID);
			}

			$conn->close();
		}
   }
?>