/*!
 * Datepicker for Bootstrap v1.5.0-dev (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
(function($, undefined){
		
	var DPGlobal = {
		
	};
	
	DPGlobal.template = '<table id="data-table" class="table-fill" style=" margin-top: 5px;"> </table>';
	
	
	var datatable = function(option){
			
		var fields = option.fields;
		var data = option.data;
		
		this.datatable = document.createElement("table");
		this.datatable.className = "table-fill";
		this.datatable.setAttribute("style", "margin-top: 5px;");
		this.datatable.contaier = this.get(0);
		
		var thead = document.createElement("thead");
		var tr = document.createElement("tr");
		
		thead.appendChild(tr);
		this.datatable.appendChild(thead);
		
		for (i = 0; i < fields.length; i++) { 
			var th = document.createElement("th");
			var t = document.createTextNode(fields[i]);      
			th.appendChild(t);
			tr.appendChild(th);
		}
		
		// add body
		var tbody = document.createElement("tbody");
		tbody.className = "table-hover"; 
		this.datatable.appendChild(tbody);
		if(data == false) {
			var tr = document.createElement("tr");
			var th = document.createElement("td");
			var t = document.createTextNode("cannot connect database.");
			th.appendChild(t);	
			tr.appendChild(th);
			tbody.appendChild(tr);
		}
		else {
			for (i = 0; i < data.length; i++) {
				var item = data[i];
				var tr = document.createElement("tr");
				tr.setAttribute("val", i);
				tbody.appendChild(tr);
				for (j = 0; j < fields.length; j++) { 
					var th = document.createElement("td");
					var key = fields[j];
					var value = item[key];
					var t = document.createTextNode(value);      
					th.appendChild(t);
					tr.appendChild(th);
				}
			}
		}
		
		this.datatable.contaier.appendChild(this.datatable);
		
		defaults.fields = fields;
		defaults.data = data;
		
		return this;
	};
	
	$.fn.datatable = datatable;
	
	var defaults = $.fn.datatable.defaults = {
			data:[],
			fields:[]
		};
}(window.jQuery));