$(document).ready(function () {
	var BASE_URL = site_url; //Jika online diganti nama domain

	$(function () {
		$('[data-toggle="infoBtnBayar"]').tooltip()
	})
	$(function () {
		$('[data-toggle="infoBtnOngkir"]').tooltip()
	})
	$('#dataLengkap').change(function () {
		if (this.checked) {
			$('#cekOngkir').prop('disabled', false) //aktif button cek ongkir

			$('#alamat').prop('readonly', true)
			$('#kode_pos').prop('readonly', true)
			$('#nohp').prop('readonly', true)
			$('#penerima').prop('readonly', true)
		} else {
			$('#cekOngkir').prop('disabled', true) //nonaktif button cek ongkir
			$('#btnBayar').prop('disabled', true);
			$('#alamat').prop('readonly', false)
			$('#kode_pos').prop('readonly', false)
			$('#nohp').prop('readonly', false)
			$('#penerima').prop('readonly', false)
		}

	})

	$('#kota_tujuan').select2({
		placeholder: 'Pilih Kota Tujuan',
		language: "id"
	});

	$.ajax({
		type: "GET",
		dataType: "html",
		url: BASE_URL + 'ongkir/data_kota/kotatujuan',
		success: function (msg) {
			$("select#kota_tujuan").html(msg);
		}
	});

	$('#ongkir').submit(function (e) {
		var dataForm = $(this).serialize();
		e.preventDefault();
		$.ajax({
			url: BASE_URL + 'ongkir/cek_ongkir',
			type: 'post',
			dataType: 'json',
			data: dataForm,
			success: function (data, txt, code) {
				$('.serviceRO').prop('disabled', false);
				pecahData(data);
				var dataForm1 = $('#ongkir').serialize();
				$.ajax({
					url: BASE_URL + 'ongkir/getDetailOngkir',
					type: 'POST',
					dataType: 'json',
					data: dataForm1,
					success: function (data, txt, code) {

					},
					error: function (data) {
						if (data.status == 501) {
							Swal.fire('Upsss!', data.responseText);
						} else {
							$('#btnBayar').prop('disabled', false);
							Swal.fire('Horayy!', 'Silahkan Lanjutkan Pembayaran');
						}
					}
				});
			},
			error: function (data) {
				Swal.fire('Upsss!', data.responseText);
			}
		});
	});


	function pecahData(data) {
		// let newData = JSON.stringify( data , null, '\t');
		// console.log(newData);

		$('.serviceRO').children('option').remove();

		$('.serviceRO').append(data.map(function (sObj) {
			return '<option data-totalfix="' + (parseInt(sObj.total) + parseInt(sObj.cost.map(a => a.value))) + '" data-harga="' +
				sObj.cost.map(a => a.value) + '" data-est="' +
				sObj.cost.map(a => a.etd) + '" value="' +
				sObj.service + '">' +
				sObj.service + '</option>'
		}));

		$('.serviceRO :nth-child(1)').prop('selected', true);
		$('#ROest').text('Estimasi ' + $('.serviceRO').find(':selected').data('est') + ' Hari')
		$('#ROcost').text('Rp ' + formatMoney($('.serviceRO').find(':selected').data('harga')))
		$('#totalFinal').text('Rp ' + formatMoney($('.serviceRO').find(':selected').data('totalfix')))
		// console.log($('.serviceRO').find(':selected').data('totalfix'))
		$('.serviceRO').on('change', function () {
			$('#ROest').text('Estimasi ' + $('.serviceRO').find(':selected').data('est') + ' Hari')
			$('#ROcost').text('Rp ' + formatMoney($('.serviceRO').find(':selected').data('harga')))
			$('#totalFinal').text('Rp ' + formatMoney($('.serviceRO').find(':selected').data('totalfix')))
			$.ajax({
				url: BASE_URL + 'ongkir/getDetailOngkir',
				type: 'POST',
				dataType: 'json',
				data: $('#ongkir').serialize(),
				success: function (res) {
					// if (res.success !== 'true') {
					// $('.errors').text(data);

					// }
				},
				error: function (data) {
					console.log(data);
					if (data.status == 501) {
						Swal.fire('Upsss!', data.responseText);
					} else {
						Swal.fire('Horayy!', 'Silahkan Lanjutkan Pembayaran');
						$('#btnBayar').prop('disabled', false);
					}
				}
			});
		});

		$('#totalBayar').val($('.serviceRO').find(':selected').data('totalfix'));
		$('#estimasi').val($('#ROest').text());
		$('#total_ongkir').val($('.serviceRO').find(':selected').data('harga'));
	}

	$('#kurir').on('change', function () {
		$('.serviceRO').children('option').remove();
		$('.serviceRO').prop('disabled', true);
		$('#ROest').text('')
		$('#ROcost').text('')
		$('#btnBayar').prop('disabled', true);
		$('#totalFinal').text('')
	});

	$('#kota_tujuan').on('change', function () {
		$('.serviceRO').children('option').remove();
		$('.serviceRO').prop('disabled', true);
		$('#ROest').text('')
		$('#ROcost').text('')
		$('#btnBayar').prop('disabled', true);
		$('#totalFinal').text('')
	});

	function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ".") {
		try {
			decimalCount = Math.abs(decimalCount);
			decimalCount = isNaN(decimalCount) ? 0 : decimalCount;

			const negativeSign = amount < 0 ? "-" : "";

			let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
			let j = (i.length > 3) ? i.length % 3 : 0;

			return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
		} catch (e) {
			console.log(e)
		}
	};

});
