"use strict";
var KTDatatablesBasicHeaders = function () {

	var initTable1 = function () {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-4'p>>",
			responsive: true,
			buttons: [{
				extend: 'collection',
				text: '<i class="la la-download"></i>Export',
				buttons: [{
					extend: 'pdf',
					title: 'Data Customers',
					titleAttr: 'PDF',
					exportOptions: {
						columns: "thead th:not(.noExport)"
					}
				}, {
					extend: 'excel',
					text: 'Excel',
					title: 'Data Customers',
					titleAttr: 'Excel',
					exportOptions: {
						columns: "thead th:not(.noExport)"
					}
				}, {
					extend: 'print',
					title: 'Data Customers',
					titleAttr: 'Print',
					exportOptions: {
						columns: "thead th:not(.noExport)"
					}
				}]
			}],
			columnDefs: [

				{
					targets: 4,
					render: function (data, type, full, meta) {
						var status = {
							0: {
								'title': 'inactivated',
								'class': 'kt-badge--dark'
							},
							1: {
								'title': 'activated',
								'class': 'kt-badge--brand'
							},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
					},
				},
				{
					targets: 6,
					render: function (data, type, full, meta) {
						var status = {
							0: {
								'title': 'Offline',
								'state': 'danger'
							},
							1: {
								'title': 'Online',
								'state': 'success'
							},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
							'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
					},
				},
			],
		});
	};

	return {

		//main function to initiate the module
		init: function () {
			initTable1();
		},

	};

}();

jQuery(document).ready(function () {
	KTDatatablesBasicHeaders.init();
});
