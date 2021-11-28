"use strict";
var KTDatatablesBasicHeaders = function () {

	var initTable1 = function () {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-8'><'col-sm-12 col-md-4'p>>",
			responsive: true,
		});
	};

	var initTable2 = function () {
		var table = $('#kt_table_2');

		// begin first table
		table.DataTable({
			dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-8'><'col-sm-12 col-md-4'p>>",
			responsive: true,
		});
	};

	return {

		//main function to initiate the module
		init: function () {
			initTable1();
			initTable2();
		},

	};

}();

jQuery(document).ready(function () {
	KTDatatablesBasicHeaders.init();
});
