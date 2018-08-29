// 28-08-2018
// alex
// autcomp_autors.js

 // $(function() {
 //     $("input[id^='nom_aut']").autocomplete({
 //         source: "srv/autors.php"
 //     });
 // });

// $("input[id^='nom_aut']").on("focus", function(){
//     $(this).autocomplete({
// 	minLength: 2,
// 	source: "srv/autors.php"
//     });
// });

// $(function() {
//     $("[id^=nom_aut]").autocomplete({
// 	source: "srv/autors.php"
//     });
// });
function autoco(){
    $(function() {
	$('.autoc').on("focus", function(){
	    $(this).autocomplete({
		source: "srv/autors.php"
            });
	});
    });
}
