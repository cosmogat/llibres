// 28-08-2018
// alex
// autcomp_autors.js
function autoco(){
    $(function() {
	$('.autoc').on("focus", function(){
	    $(this).autocomplete({
		source: "srv/autors.php"
            });
	});
    });
}
