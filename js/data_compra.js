// 28-08-2018
// alex
// data_compra.js

$(function() {
    $.datepicker.regional['cat'] = {
	closeText: 'Tancar',
	prevText: '<Pre',
	nextText: 'Seg>',
	currentText: 'Avui',
	monthNames: ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny',
		     'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'],
	monthNamesShort: ['Gen', 'Febr', 'Març', 'Abr', 'Maig', 'Juny',
			  'Jul', 'Ag', 'Sep', 'Oct', 'Nov', 'Des'],
	dayNames: ['Diumenge', 'Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte'],
	dayNamesShort: ['dg', 'dl', 'dm', 'dc', 'dj', 'dv', 'ds'],
	dayNamesMin: ['dg', 'dl', 'dt', 'dc', 'dj', 'dv', 'ds'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
    $.datepicker.setDefaults($.datepicker.regional["cat"]);
    $("#data_compra").datepicker();
} );
// el dia de demà aquest arxiu no s'ha de gastar i s'utilitzarà <input type="date">
// s'utilitza en modllibres.php (modllibres.html)
