<?php
//=======================================================================================
// File Name	:	conf.define.php
// Author		:	kkang(sinbiweb)
// Update		:	2014-07-29
// Description	:	사이트 변수설정 파일
//=======================================================================================

### table define ###
$arr_table = array(
					"sw_admin",
					"sw_admlv",
					"sw_counter",
					"sw_popup",
					"sw_visual",
					"sw_banner",
					"sw_board_cnf",
					"sw_board_cate",
					"sw_board",
					"sw_boardfile",
					"sw_comment",
					"sw_category",
					"sw_gicon",
					"sw_member",
					"sw_emoney_inf",
					"sw_delivery",
					"sw_cart",
					"sw_ordcart",
					"sw_goods",
					"sw_goption",
					"sw_order_tmp",
					"sw_order",
					"sw_order_item",
					"sw_counsel",
					"sw_wish",
					"sw_bank",
					"sw_emoney",
					"sw_coupon_cfg",
					"sw_coupon",
					"sw_attendance",
					"sw_config",
					"sw_calendar",
					"sw_sms",
					"sw_smslog"
			);
foreach($arr_table as $v)
	define(strtoupper($v), $v);

unset($arr_table);

### admin menu ###
$arr_menu = array(
				basic => "쇼핑몰기본관리",
				member => "회원관리",
				order => "주문관리",
				goods => "상품관리",
				board => "게시판관리",
				design => "팝업관리",
				log => "통계"

			);

### 목록 출력수 ###
$arr_cnt = array("10", "20", "40", "60", "100");


### 게시판권한 ###
$arr_auth = array(
					"0" => "제한없음",
					"10" => "준회원",
					"20" => "정회원",
					"90" => "관리자"
				);

$auth_keys = array_keys($arr_auth);

### 게시판유형 ###
$arr_part = array(
					"10" => "일반게시판",
					"20" => "1:1문의",
					"30" => "FAQ",
					"40" => "자료실",
					"50" => "갤러리",
					"60" => "썸네일",
					"70" => "이벤트",
					"80" => "LME정보"
				);

$part_keys = array_keys($arr_part);

### 게시판스킨폴더 ###
$arr_skin = array(
					"10" => "default",
					"20" => "ask",
					"30" => "faq",
					"40" => "pds",
					"50" => "gallery",
					"60" => "thum",
					"70" => "event",
					"80" => "lme"
				);
 
### 월배열 ###
$arr_mon = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

### 요일배열 ###
$arr_w = array("일","월","화","수","목","금","토");
 

### 은행명 구분 ###
$arr_bank = array("국민은행", "우리은행", "신한은행", "농협은행", "하나은행", "SC은행", "기업은행", "산업은행", "외한은행", "씨티은행","HSBC은행","도이치은행","경남은행","전북은행","광주은행","대구은행","부산은행","제주은행","우체국은행","새마을금고","수협은행","신협은행");

###대화주제###
$arr_subject = array("영상채팅해요~","지금 만나요~","그린라이트 일까요?" ,"그린라이트를 원해!","친구 구해요~","영화구경 갈까요?","스포츠 좋아해요?","드라이브해요~","고민 있어요...","수다나 떨어요~","애인 없어요...","연애란 무엇일까?","진로 상담 바래요","무엇이든 물어보세요~","여자는 왜이래요?","질문 있어요~","조언 구해요~","심심풀이~");
?>