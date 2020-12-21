(function($) {
    $.fn.serializefiles = function() {
        var obj = $(this);

        var form_data = new FormData(this[0]);
        $.each($(obj).find('input[type="file[]"]'), function(i, tag) {
            $.each($(tag)[0].files, function(i, file) {
                form_data.append(tag.name, file);
            });
        });

        var params = $(obj).serializeArray();
        $.each(params, function (i, val) {
            form_data.append(val.name, val.value);
        });

        return form_data;
    };
    })(jQuery);
$(document).ready(function () {

    $(document).on('click', '#add_house', function (e) {
        // home page hide
        $('#provincecode').attr('id', 'province');
        $('#districtcode').attr('id', 'district');
        $('#sectorcode').attr('id', 'sector');
        $('#codecell').attr('id', 'cell');

        e.stopPropagation();
        var house_view = $(this).data('house');

        $.ajax({
            url: 'core/ajax_db/house_addcategories.php',
            method: 'POST',
            dataType: 'text',
            data: {
                house_view: house_view,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                $(".house-popup").hide();
                
                $('#province').attr('id', 'provincecode');
                $('#district').attr('id', 'districtcode');
                $('#sector').attr('id', 'sectorcode');
                $('#cell').attr('id', 'codecell');
                });
                console.log(response);
            }
        });
    });

    $(document).on('click', '#property_request_clients', function (e) {
        $('.progress-hidex').hide();
        $('.progress-hidec').hide();
        $('.progress-hidez').hide();

        e.stopPropagation();
        var house_view = $(this).data('house');

        $.ajax({
            url: 'core/ajax_db/property_request_add.php',
            method: 'POST',
            dataType: 'text',
            data: {
                house_view: house_view,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                $(".house-popup").hide();
                });
                console.log(response);
            }
        });
    });

    $(document).on('click', '#contacts_business', function (e) {

        e.stopPropagation();
        var contacts_business = $(this).data('contacts');

        $.ajax({
            url: 'core/ajax_db/contact.php',
            method: 'POST',
            dataType: 'text',
            data: {
                contacts_business: contacts_business,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                $(".house-popup").hide();
                });
                console.log(response);
            }
        });
    });

    $(document).on('click', '#contacts_us', function (e) {

        e.stopPropagation();
        var contacts_us = $(this).data('contacts');

        $.ajax({
            url: 'core/ajax_db/contact.php',
            method: 'POST',
            dataType: 'text',
            data: {
                contacts_us: contacts_us,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                $(".house-popup").hide();
                });
                console.log(response);
            }
        });
    });
    

    $(document).on('click', '#house-readmore', function (e) {
        e.stopPropagation();
        var house_id = $(this).data('house');

        $.ajax({
            url: 'core/ajax_db/property-readmore.php',
            method: 'POST',
            dataType: 'text',
            data: {
                house_id: house_id,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                    $(".house-popup").hide();
                });
                console.log(response);
            }
        });
    });

    $(document).on('click', '#contacts_agent', function (e) {
        e.stopPropagation();
        var user_id = $(this).data('user');

        $.ajax({
            url: 'core/ajax_db/property-readmore.php',
            method: 'POST',
            dataType: 'text',
            data: {
                contacts_agent: 'contacts_agent',
                user_id_agent: user_id,

            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                    $(".house-popup").hide();
                });
                console.log(response);
            }
        });
    });


    $(document).on('click', '#submit_form', function (e) {
        var form_id = $('#form-house');
        // event.preventDefault();
        e.stopPropagation();
        // var title = $('#title');
        var authors = $('#authors');
        var additioninformation = $('#addition-information');
        var photo = $('#photo');
        var other_photo = $('#other-photo');
        // var video = $('#video');
        // var youtube = $('#youtube');
        var categories_house = $('#categories_house_');
        var name_of_house = $('#name_of_house');
        var equipment = $('#equipment_');
        var Minimum_bedrooms = $('#Minimum_bedrooms');
        var Minimum_bathrooms = $('#Minimum_bathrooms');
        var car_in_garage = $('#car_in_garage');
        var price = $('#price');
        var phone = $('#phone');
        var country = $('#country');
        var province = $('.provincecode');
        var districts = $('.districtcode');
        var sector = $('.sectorcode');
        var cell = $('.codecell');
        var village = $('.CodeVillage');
        var photo_Title1 = $('#photo-Title1');
        
        if (isEmpty(country) && isEmpty(province) && isEmpty(districts) &&
            isEmpty(sector) && isEmpty(cell) && isEmpty(village) && isEmpty(name_of_house) && isEmpty(authors) && isEmpty(phone) &&
            isEmpty(categories_house) && isEmpty(equipment) && isEmpty(price)  && isEmpty(Minimum_bedrooms) && 
            isEmpty(Minimum_bathrooms) && isEmpty(car_in_garage) &&
            isEmpty(additioninformation) && isEmpty(photo_Title1) && isEmpty(photo) &&
            isEmpty(other_photo)
            
            ) {
            
            var extensions3 = $('#photo').val().split('.').pop().toLowerCase();
            var extensions4 = $('#other-photo').val().split('.').pop().toLowerCase();

            if (jQuery.inArray(extensions3, ['gif', 'png', 'jpg', 'mp4', 'mp3', 'jpeg', 'bmp', 'pdf', 'doc', 'ppt', 'docx', 'xlsx', 'xls', 'zip']) == -1) {
                $("#responseSubmithouse").html('Invalid Image File').fadeIn();
                setInterval(function () {
                    $("#responseSubmithouse").fadeOut();
                }, 4000);
                $('#photo').val('');
                return false;
            } else if (jQuery.inArray(extensions4, ['gif', 'png', 'jpg', 'mp4', 'mp3', 'jpeg', 'bmp', 'pdf', 'doc', 'ppt', 'docx', 'xlsx', 'xls', 'zip']) == -1) {
                $("#responseSubmithouse").html('Invalid Image File').fadeIn();
                setInterval(function () {
                    $("#responseSubmithouse").fadeOut();
                }, 4000);
                $('#other-photo').val('');
                return false;
            } else {
                $.ajax({
                    url: 'core/ajax_db/house_addcategories.php',
                    method: "POST",
                    data: form_id.serializefiles(),
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            var progress = Math.round((e.loaded / e.total) * 100);
                            $('.progress-hidex').show();
                            $('.progress-hidec').show();
                            $('.progress-hidez').show();
                            $('#prox').css('width', progress + '%');
                            $('#proc').css('width', progress + '%');
                            $('#proz').css('width', progress + '%');
                            $('#prox').html(progress + '%');
                            $('#proc').html(progress + '%');
                            $('#proz').html(progress + '%');
                        });

                        xhr.addEventListener('load', function (e) {
                            $('.progress-bar').removeClass('bg-info').addClass('bg-success').html('<span>upload completed  <span class="fa fa-check"></span></span>');
                        });
                        return xhr;
                    },
                    success: function (response) {
                        $("#responseSubmithouse").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseSubmithouse").fadeOut();
                        }, 2000);
                        setInterval(function () {
                            location.reload();
                        }, 2400);
                    }, error: function (response) {
                        $("#responseSubmithouse").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseSubmithouse").fadeOut();
                        }, 3000);
                    }
                });
                return false;
            }
        }
    });

    $(document).on('click', '#submit_form_hide_bedbath', function (e) {
        var form_id = $('#form-house');
        // event.preventDefault();
        e.stopPropagation();
        // var title = $('#title');
        var authors = $('#authors');
        var additioninformation = $('#addition-information');
        var photo = $('#photo');
        var other_photo = $('#other-photo');
        // var video = $('#video');
        // var youtube = $('#youtube');
        var categories_house = $('#categories_house_');
        var name_of_house = $('#name_of_house');
        var price = $('#price');
        var phone = $('#phone');
        var country = $('#country');
        var province = $('.provincecode');
        var districts = $('.districtcode');
        var sector = $('.sectorcode');
        var cell = $('.codecell');
        var village = $('.CodeVillage');
        var photo_Title1 = $('#photo-Title1');
        
        if (isEmpty(country) && isEmpty(province) && isEmpty(districts) &&
            isEmpty(sector) && isEmpty(cell) && isEmpty(village) && isEmpty(name_of_house) && isEmpty(authors) && isEmpty(phone) &&
            isEmpty(categories_house) && isEmpty(price)  &&
            isEmpty(additioninformation) && isEmpty(photo_Title1) && isEmpty(photo) &&
            isEmpty(other_photo)
            
            ) {
            
            var extensions3 = $('#photo').val().split('.').pop().toLowerCase();
            var extensions4 = $('#other-photo').val().split('.').pop().toLowerCase();

            if (jQuery.inArray(extensions3, ['gif', 'png', 'jpg', 'mp4', 'mp3', 'jpeg', 'bmp', 'pdf', 'doc', 'ppt', 'docx', 'xlsx', 'xls', 'zip']) == -1) {
                $("#responseSubmithouse").html('Invalid Image File').fadeIn();
                setInterval(function () {
                    $("#responseSubmithouse").fadeOut();
                }, 4000);
                $('#photo').val('');
                return false;
            } else if (jQuery.inArray(extensions4, ['gif', 'png', 'jpg', 'mp4', 'mp3', 'jpeg', 'bmp', 'pdf', 'doc', 'ppt', 'docx', 'xlsx', 'xls', 'zip']) == -1) {
                $("#responseSubmithouse").html('Invalid Image File').fadeIn();
                setInterval(function () {
                    $("#responseSubmithouse").fadeOut();
                }, 4000);
                $('#other-photo').val('');
                return false;
            } else {
                $.ajax({
                    url: 'core/ajax_db/house_addcategories.php',
                    method: "POST",
                    data: form_id.serializefiles(),
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            var progress = Math.round((e.loaded / e.total) * 100);
                            $('.progress-hidex').show();
                            $('.progress-hidec').show();
                            $('.progress-hidez').show();
                            $('#prox').css('width', progress + '%');
                            $('#proc').css('width', progress + '%');
                            $('#proz').css('width', progress + '%');
                            $('#prox').html(progress + '%');
                            $('#proc').html(progress + '%');
                            $('#proz').html(progress + '%');
                        });

                        xhr.addEventListener('load', function (e) {
                            $('.progress-bar').removeClass('bg-info').addClass('bg-success').html('<span>upload completed  <span class="fa fa-check"></span></span>');
                        });
                        return xhr;
                    },
                    success: function (response) {
                        $("#responseSubmithouse").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseSubmithouse").fadeOut();
                        }, 2000);
                        setInterval(function () {
                            location.reload();
                        }, 2400);
                    }, error: function (response) {
                        $("#responseSubmithouse").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseSubmithouse").fadeOut();
                        }, 3000);
                    }
                });
                return false;
            }
        }
    });

    $(document).on('click', '#submit_clientToAgent', function (e) {
        e.preventDefault();
        var form_id = $('#form_agentMessage');
        // e.stopPropagation();
        var name = $('#name_clientToAgent');
        var email = $('#email_clientToAgent');
        var phone = $('#phone_clientToAgent');
        var message = $('#message_clientToAgent');
        
        if (isEmpty(name) && isEmpty(email) &&  isEmpty(phone) && isEmpty(message)) {
         
            $.ajax({
                    url: 'core/ajax_db/property-readmore.php',
                    method: "POST",
                    data: form_id.serialize(),
                    success: function (response) {
                        $("#responseAgentMessage").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseAgentMessage").fadeOut();
                        }, 2500);
                        setInterval(function () {
                            // location.reload();
                        }, 2800);
                    }, error: function (response) {
                        $("#responseAgentMessage").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseAgentMessage").fadeOut();
                        }, 3000);
                    }
                });
                return false;
          
            }
    });

    $(document).on('click', '#newslatter_form_submit', function (e) {
        e.stopPropagation();
        var email = $('#newslatter_email_client');
        var form_id = $('#newslatter_form');

        
        if (isEmpty(email)) {
         
            $.ajax({
                    url: 'core/ajax_db/property-readmore.php',
                    method: "POST",
                    data: form_id.serialize(),
                    success: function (response) {
                        $("#responseNewslatter").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseNewslatter").fadeOut();
                        }, 3500);
                        setInterval(function () {
                            // location.reload();
                        }, 3800);
                    }, error: function (response) {
                        $("#responseNewslatter").html(response).fadeIn();
                        setInterval(function () {
                            $("#responseNewslatter").fadeOut();
                        }, 3000);
                    }
                });
                return false;
          
            }
    });

    $(document).on('click', '.imagehouseViewPopup', function (e) {
        e.stopPropagation();
        var house_id = $(this).data('fund');
        $.ajax({
            url: 'core/ajax_db/houseImageViewPopup.php',
            method: 'POST',
            dataType: 'text',
            data: {
                showpimage: house_id,
            }, success: function (response) {
                $(".popupTweet").html(response);
                $(".close-imagePopup").click(function () {
                    $(".img-popup").hide();
                });
                console.log(response);
            }
        });
    });
});

function client_business(key) {
    var name_client_ = $("#name_client_");
    var email_client_ = $("#email_client_");
    var Request_Type_client_ = $("#Request_Type_client_");
    var property_type_client_ = $("#property_type_client_");
    var equipment_client_ = $("#equipment_client_");
    var Minimum_bedrooms_client_ = $("#Minimum_bedrooms_client_");
    var Minimum_bathrooms_client_ = $("#Minimum_bathrooms_client_");
    var location = $("#location_client");
    var phone_client_ = $("#phone_client_");
    var currency = $("#currency");
    var price = $("#price");
    var messages_client_ = $("#messages_client_");
    //   use 1 or second method to validaton
    if (isEmpty(name_client_) && isEmpty(email_client_) && isEmpty(Request_Type_client_) && isEmpty(property_type_client_) &&
        isEmpty(equipment_client_) && isEmpty(Minimum_bedrooms_client_) && isEmpty(Minimum_bedrooms_client_) && isEmpty(Minimum_bathrooms_client_) &&
        isEmpty(location) && isEmpty(phone_client_) && isEmpty(currency) && isEmpty(price) &&  isEmpty(messages_client_)
    ) {
        //    alert("complete register");
        $.ajax({
            url: 'core/ajax_db/contact.php',
            method: "POST",
            dataType: "text",
            data: {
                key: key,
                name_client_: name_client_.val(),
                email_client_: email_client_.val(),
                Request_Type_client_: Request_Type_client_.val(),
                property_type_client_: property_type_client_.val(),
                equipment_client_: equipment_client_.val(),
                Minimum_bedrooms_client_: Minimum_bedrooms_client_.val(),
                Minimum_bathrooms_client_: Minimum_bathrooms_client_.val(),
                location: location.val(),
                phone_client_: phone_client_.val(),
                currency: currency.val(),
                price: price.val(),
                messages_client_: messages_client_.val(),
            },
            success: function(response) {
                $("#responses").html(response);
                console.log(response);
                if (response.indexOf('SUCCESS') >= 0) {
                    setInterval(() => {
                        // window.location = '../index.php';
                        // location.reload();
                    }, 1500);
                }else {
                   isEmptys(name_client_) || isEmptys(email_client_) 
                }
            }
        });
    }
}

function contact_business(key) {
    var name_client_ = $("#name_client_0");
    var email_client_ = $("#email_client_0");
    var phone_client_ = $("#phone_client_0");
    var messages_client_ = $("#messages_client_0");
    //   use 1 or second method to validaton
    if (isEmpty(name_client_) && isEmpty(email_client_) && isEmpty(phone_client_) &&  isEmpty(messages_client_)
    ) {
        //    alert("complete register");
        $.ajax({
            url: 'core/ajax_db/contact.php',
            method: "POST",
            dataType: "text",
            data: {
                key: key,
                name_client_: name_client_.val(),
                email_client_: email_client_.val(),
                phone_client_: phone_client_.val(),
                messages_client_: messages_client_.val(),
            },
            success: function(response) {
                $("#responses").html(response);
                console.log(response);
                if (response.indexOf('SUCCESS') >= 0) {
                    setInterval(() => {
                        // window.location = '../index.php';
                        // location.reload();
                    }, 1500);
                }else {
                   isEmptys(name_client_) || isEmptys(email_client_) 
                }
            }
        });
    }
}



function property_request(key) {
    var Request_Type = $("#Request_Type");
    var property_type = $("#property_type");
    var equipment = $("#equipment");
    var Minimum_bedrooms = $("#Minimum_bedrooms");
    var Minimum_bathrooms = $("#Minimum_bathrooms");
    var details_of_property_request = $("#details_of_property_request");
    var location_client = $("#location_client");
    var details_about_neighborhood = $("#details_about_neighborhood");
    var currency = $("#currency");
    var price = $("#price_");
    var Payable = $("#Payable");
    var urgent = $("#urgent");
    var firstname = $("#firstname");
    var lastname = $("#lastname");
    var email = $("#email");
    var telephone = $("#telephone");
    //   use 1 or second method to validaton
    if (isEmpty(Request_Type) && isEmpty(property_type) && isEmpty(equipment) && isEmpty(Minimum_bedrooms) &&
        isEmpty(Minimum_bathrooms) && isEmpty(details_of_property_request) && isEmpty(location_client) && 
        isEmpty(details_about_neighborhood) &&  isEmpty(currency) &&  isEmpty(price) && isEmpty(Payable) && 
        isEmpty(urgent) && isEmpty(firstname)&& isEmpty(lastname) && isEmpty(email) && isEmpty(telephone)
    ) {
        //    alert("complete register");
        $.ajax({
            url: 'core/ajax_db/property_request_add.php',
            method: "POST",
            dataType: "text",
            data: {
                key: key,
                Request_Type : Request_Type.val(),
                property_type : property_type.val(),
                equipment : equipment.val(),
                Minimum_bedrooms : Minimum_bedrooms.val(),
                Minimum_bathrooms : Minimum_bathrooms.val(),
                details_of_property_request : details_of_property_request.val(),
                location_client : location_client.val(),
                details_about_neighborhood : details_about_neighborhood.val(),
                currency : currency.val(),
                price : price.val(),
                Payable : Payable.val(),
                urgent : urgent.val(),
                firstname : firstname.val(),
                lastname : lastname.val(),
                email: email.val(),
                telephone: telephone.val(),
            },
            success: function(response) {
                $("#responses").html(response);
                console.log(response);
                if (response.indexOf('SUCCESS') >= 0) {
                    setInterval(() => {
                        // window.location = '../index.php';
                        // location.reload();
                    }, 1500);
                }else {
                    $("#responses").html("missing..");
                }
            }
        });
    }
}



function isEmpty(caller) {
    if (caller.val() == "") {
        caller.css("outline", "1px solid red");
        return false;
    } else {
        caller.css("outline", "1px solid green ");
    }
    return true;
}

function isEmptys(caller) {
    if (caller.val() != "") {
        caller.css("outline", "1px solid red");
        return false;
    }
    return true;
}
