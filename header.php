<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iragiro House</title>
    <!-- favicon must be with index website to compress it is /favicon.io/favicon.cc-->
	<!-- <link rel="icon"  type="image/png" href="< ?php echo BASE_URL;?>assets/image/img/partner/partner-4.png" size"32x32" > -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
     <!-- Google Font -->
     <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

	<!-- Css Styles -->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/login.css" >
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/plugin/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/dataTables.bootstrap4.min.css" type="text/css" >
    <!-- <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/responsive.bootstrap4.min.css" type="text/css" > -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/timeline.css" type="text/css">
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/imagePopup.css" type="text/css">
	<!-- <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/jquery.range.css" type="text/css"> -->
    <link rel="stylesheet" href="<?php echo BASE_URL_LINK ;?>css/ui.totop.css" >
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/profile.css" type="text/css">

    <script type="text/javascript">
    
    function showResult(){
		var provincecode=document.getElementById('provincecode').value;
		var params = "&provincecode="+provincecode+"";
		http=new XMLHttpRequest();
		http.open("POST","core/ajax_db/getdistrict.php",true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		http.send(params);
		http.onreadystatechange = function() 
		{//Call a function when the province changes.
			
		document.getElementById("districtcode").innerHTML= http.responseText;
				
		if(document.getElementById('districtcode').value!=="No District Available")
		document.form.name.disabled=false;
		
		}		
	}
	    
		
	    //Get sectors list
		function showResult2(){
		var districtcode=document.getElementById('districtcode').value;
		var params = "&districtcode="+districtcode+"";
		http=new XMLHttpRequest();
		http.open("POST","core/ajax_db/getsector.php",true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		http.send(params);
		http.onreadystatechange = function() 
		{//Call a function when the district changes.
			
		document.getElementById("sectorcode").innerHTML=http.responseText;
				
		if(document.getElementById('sectorcode').value!=="No Sector Available")
		document.form.name.disabled=false;
		
		}		
	}
	
    //Get cell list
    function showResult3(){
		var sectorcode=document.getElementById('sectorcode').value;
		var params = "&sectorcode="+sectorcode+"";
		http=new XMLHttpRequest();
		http.open("POST","core/ajax_db/getcell.php",true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		http.send(params);
		http.onreadystatechange = function() 
		{//Call a function when the sector changes.
			
		document.getElementById("codecell").innerHTML=http.responseText;
				
		if(document.getElementById('codecell').value!=="No Cell Available")
		document.form.name.disabled=false;
		
		}		
    }

    //Get cell list
  
	// Get Villages list
    function showResult4(){
		var codecell=document.getElementById('codecell').value;
		var params = "&codecell="+codecell+"";
		http=new XMLHttpRequest();
		http.open("POST","core/ajax_db/getvillage.php",true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.send(params);
		http.onreadystatechange = function() 
		{
            // Call a function when the cell changes.
			
		document.getElementById("CodeVillage").innerHTML=http.responseText;
				
		if(document.getElementById('CodeVillage').value!=="No village Available")
		document.form.name.disabled=false;
		
		}		
	}
	
  
    function foodCategories(categories,id,user_id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'core/ajax_db/foodView_FecthPaginat.php?pages=' + id + '&categories=' + categories+ '&user_id=' + user_id, true);
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                switch (categories) {
                    case categories:
                         var pagination = document.getElementById('food-hides');
                         pagination.innerHTML = xhr.responseText;
                        break;
                }
            }
        };
          xhr.addEventListener('progress',function(e){
             var progress= Math.round((e.loaded/e.total)*100);
             $('.progress-navbar').show();
             $('#progress_width').css('width',progress +'%');
             $('#progress_width').html(progress +'%');
         }, false);

        xhr.addEventListener('load', function (e) { 
            $('.progress-bar').removeClass('bg-info').addClass('bg-danger').html('<span> completed  <span class="fa fa-check"></span></span>');
            setInterval(function () {
                $(".progress-navbar").fadeOut();
            }, 2000);
        }, false);

    }

    function house_agentCategories(categories,id,user_id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'core/ajax_db/house_agent_Fecth.php?pages=' + id + '&categories=' + categories + '&user_id=' + user_id, true);
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                switch (categories) {
                    case categories:
                         var pagination = document.getElementById('house-hide');
                         pagination.innerHTML = xhr.responseText;
                        break;
                }
            }
        };
    }
  
    function houseRange(range,id,user_id) {
        var xhr = new XMLHttpRequest();
        var params ='&pages=' + id + '&price_range=' + range + '&user_id=' + user_id;
		xhr.open("POST","core/ajax_db/house_add.php",true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(params);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                var pagination = document.getElementById('property-list');
                pagination.innerHTML = xhr.responseText;

            }
        };
    }
	
    function houseRangeLayout(range,id,user_id) {
        var xhr = new XMLHttpRequest();
        var params ='&pages=' + id + '&price_range=' + range + '&user_id=' + user_id;
		xhr.open("POST","core/ajax_db/propertyView_range.php",true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(params);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                        var pagination = document.getElementById('house-hide');
                        pagination.innerHTML = xhr.responseText;
            }
        };
    }

    
    function xxda(requests,formx, id) {
        var xhr = new XMLHttpRequest();
        var form = document.getElementById(formx);
        var formData = new FormData(form);
        // Add any event handlers here...
        xhr.open('POST', 'index.php?actions=' + requests + '&code=' + id , true);
        xhr.open('POST', 'watchlist.php?actions=' + requests + '&code=' + id , true);
        xhr.send(formData);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $("#responseSubmitfooditerm").html('<div class="alert alert-success alert-dismissible fade show text-center">'+
                     '<button class="close" data-dismiss="alert" type="button">'+
                         '<span>&times;</span>'+
                     '</button> <strong>SUCCESS</strong>'+' </div>');
                var forms = document.getElementById('responseSubmitfooditermview');
                 setInterval(function () {
                    $("#responseSubmitfooditerm").fadeOut();
                            }, 2000);
                forms.innerHTML = xhr.responseText;
            }
        };
    }
    
    function xxda_watch_list_delete(requests,formx, id) {
        var xhr = new XMLHttpRequest();
        var form = document.getElementById(formx);
        var formData = new FormData(form);
        // Add any event handlers here...
        xhr.open('POST', 'core/ajax_db/watch_list_Fecth.php?actions=' + requests + '&code=' + id , true);
        xhr.send(formData);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $("#response_msg_watchlist").html('<div class="alert alert-success alert-dismissible fade show text-center">'+
                     '<button class="close" data-dismiss="alert" type="button">'+
                         '<span>&times;</span>'+
                     '</button> <strong>SUCCESS</strong>'+' </div>');
                 $('#response_hide_watchlist'+ id).hide();
                 setInterval(function () {
                    $("#response_msg_watchlist").fadeOut();
                            }, 2000);
                
            }
        };
    }
    
    function xxda_prof_house_agent_delete(requests,formx, id) {
        var xhr = new XMLHttpRequest();
        var form = document.getElementById(formx);
        var formData = new FormData(form);
        // Add any event handlers here...
        xhr.open('POST', 'core/ajax_db/house_agent_Fecth.php?actions=' + requests + '&code=' + id , true);
        xhr.send(formData);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $("#response_msg_watchlist").html( xhr.responseText);
                 $('#response_hide_watchlist'+ id).hide();
                 setInterval(function () {
                    $("#response_msg_watchlist").fadeOut();
                            }, 2000);
            }
        };
    }
// END OF HOUSE JAVASCRIPT

// CAR FOR BUY AND SELLING FOR DEALER


    </script>
</head>