var page = (window.location.pathname);
//page show_summary
if(page.includes('show_summary')){
    function renter_changed(){
        if($("#renter").val()==""){
            $("#summary").attr("href",`#`).attr("target",`_self`);
        }
        else
            $("#summary").attr("href",`/summary/renter/${$("#renter").val()}`).attr("target",`_blank`);
    }
}
//page offer
if(page.includes('add_offer')){
    $(function(){
        $('#offer_img').on('change' , function(){
            if(document.querySelector('#offer_img').files.length>0){
                var curFiles=document.querySelector('#offer_img').files;
                // $('label.custom-file-label[for="offer_img"]').addClass("txt-master");
                if (validFileType(curFiles[0])){

                    $('label.custom-file-label[for="offer_img"]').text(curFiles[0].name);
                }
                else{
                    swal.fire({
                        title: 'صيغة الملف غير مدعومة',text: 'الصيغ المدعومة: images ',icon:'error',
                    });
                    $('#offer_img').val('');

                }
            }
            else{
                $('label.custom-file-label[for="offer_img"]').removeClass("txt-master").text('اختر صورة العرض');
            }
        });
        var fileTypes = [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif'
            // 'application/pdf'//,
            //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            //'application/vnd.ms-excel'
        ];

        function validFileType(file) {
            for (var i = 0; i < fileTypes.length; i++) {
                if (file.type === fileTypes[i]) {
                    return true;
                }
            }
            return false;
        };
    });
    function add_offer(){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        form_data.append('caption', $('#caption').val());
        form_data.append('description', $('#description').val());
        form_data.append('offer_url', $('#offer_url').val());
        form_data.append('offer_img', $('#offer_img').prop('files')[0]);
        $.ajax({
            url: `/add_offer`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                if(result == 'success'){
                    swal.fire("تم بنجاح" , "حفظ البيانات" , "success");
                }
                else{
                    swal.fire(result.title , result.message , result.icon);
                }
                $('.background').hide();
                $('#caption').val('');
                $('#description').val('');
                $('#offer_url').val('');
                $('#offer_img').val('');
                $('label.custom-file-label[for="offer_img"]').removeClass("txt-master").text('اختر صورة العرض');
            }
        });
    }
}
//page register
if(page.includes('register')){

    function promesse_changed(){
        if($('#promesse01').is(':checked') && $('#promesse02').is(':checked')){
            $('#register_btn').prop('disabled',false);
        }
        else{
            $('#register_btn').prop('disabled',true);
        }
    }
    $('#email').on('input change onpaste', function(){
        $('#email_result').hide();
        $('#email').css('border-color','var(--secondary_color)');
        var email=$('#email').val();
        if(is_email(email)){
            var _token = $('input[name="_token"]').val().trim();
            $.ajax({
                url: "/email_exists/"+email,
                method: "POST",
                data: { _token: _token },
                success: function (result) {
                    if(result){
                        $('#email_result').text('الايميل موجود مسبقاً')
                        .removeClass('d-none badge-warninig')
                        .addClass('badge-danger').show();
                        $('#email').css('border-color','var(--red)');
                        $("body").getNiceScroll().resize();
                    }
                    else{
                        $('#email').css('border-color','var(--green)');
                    }
                }
            });
        }
        else{
            $('#email_result').text('صيغة الايميل خاطئة')
                                .removeClass('d-none badge-danger')
                                .addClass('badge-warninig').show();
            $('#email').css('border-color','var(--red)');
            $("body").getNiceScroll().resize();
        }
    });

    $('#mobile_phone').on('input change onpaste', function(){
        $('#mobile_phone_result').hide();
        var mobile_phone=$('#mobile_phone');
        mobile_phone.val(is_number(mobile_phone.val()));
        if(mobile_phone.val().length==10){
            var _token = $('input[name="_token"]').val().trim();
            $.ajax({
                url: "/mobile_exists/"+mobile_phone.val(),
                method: "POST",
                data: { _token: _token },
                success: function (result) {
                    if(result){
                        $('#mobile_phone_result').text('رقم الجوال موجود مسبقاً')
                        .removeClass('d-none badge-warninig')
                        .addClass('badge-danger').show();
                        $('#mobile_phone').css('border-color','var(--red)');
                    }
                    else{
                        $('#mobile_phone').css('border-color','var(--green)');
                    }
                }
            });
        }

    });
    $('#ID').on('input change onpaste', function(){
        $('#ID_result').hide();
        var ID=$('#ID');
        ID.val(is_number(ID.val()));
        // $("body").getNiceScroll().resize();
    });

    $('#mobile_phone').on('focusout', function(){
        if($('#mobile_phone').val().length<10){
            $('#mobile_phone_result').text('رقم الجوال يجب أن يكون 10 خانات')
                        .removeClass('d-none badge-warninig')
                        .addClass('badge-danger').show();
            $('#mobile_phone').focus();
        }
        else{
            $('#mobile_phone_result').hide();
        }
        $("body").getNiceScroll().resize();
    });



    function save_user(){
        if($('#name').val().trim()=='' || $('#mobile_phone').val().length < 10 || !is_email($('#email').val().trim()) || $('#account').val()=='' ||
        $('#bank').val().trim()=="" || $('#social_status').val().trim()=="" || $('#sex').val().trim()=="" || $('#ID').val().trim()==""){
            swal.fire({
                title: "الرجاء استكمال البيانات",icon:"error",
            });
            return;
        }
        else{
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var name=$('#name').val().trim();
            var mobile_phone=$('#mobile_phone').val().trim();
            var email=$('#email').val().trim();
            var account=$('#account').val().trim();
            var bank=$('#bank').val().trim();
            var sex=$('#sex').val();
            var ID=$('#ID').val();
            var social_status=$('#social_status').val().trim();
            var form_data=new FormData();
            form_data.append('name',name);
            form_data.append('mobile_phone',mobile_phone);
            form_data.append('email',email);
            form_data.append('account',account);
            form_data.append('bank',bank);
            form_data.append('sex',sex);
            form_data.append('social_status',social_status);
            form_data.append('ID',ID);
            form_data.append('_token',_token);
            $.ajax({
                url: "/register",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    if(result.success=='true'){
                        $('#name').val('');
                        $('#sex').val('');
                        $("#sex").val('default').selectpicker("refresh");
                        $('#social_status').val('');
                        $("#social_status").val('default').selectpicker("refresh");
                        $('#mobile_phone').val('').css('border-color','var(--secondary_color)');
                        $('#email').val('').css('border-color','var(--secondary_color)');
                        $('#bank').val('');
                        $("#bank").val('default').selectpicker("refresh");
                        $('#account').val('');
                        $('#ID').val('');
                        $('.background').hide();
                        swal.fire({
                            title: result.title,text: result.message,icon:"success",
                        });
                    }
                    else{
                        $('.background').hide();
                        swal.fire({
                            title: result.title,text: result.message,icon:"error",
                        });
                    }
                }
            });
        }
    }
}
//Add_building page
if(page.includes("/add_building")){
    function add_building(){
        if($("#name").val()==""||$("#distract").val()==""){
            swal.fire("استمكل البيانات","اكتب اسم العمارة أو الحي","info");
        }
        else{
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var name=$('#name').val();
            var description=$('#description').val().trim();
            var address=$('#address').val().trim();
            var notes=$('#notes').val().trim();
            var distract=$('#distract').val().trim();
            var address_url=$('#address_url').val().trim();
            var form_data=new FormData();
            form_data.append('name',name);
            form_data.append('description',description);
            form_data.append('notes',notes);
            form_data.append('address',address);
            form_data.append('distract',distract);
            form_data.append('_token',_token);
            form_data.append('address_url',address_url);
            $.ajax({
                url: "/add_building",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    if(result=='success'){
                        swal.fire("تم بنجاح","حفظ البيانات",result);
                    }
                    else if(result=='info'){
                        swal.fire("خطأ في البيانات","الاسم مكرر",result);
                    }
                    else{
                        swal.fire(result.title,result.message,result.icon);
                    }
                    $("#name , #description ,#address_url , #address , #notes").val("");
                    $('.background').hide();
                }
            })
        }
    }
}

//apartments
if(page.includes("/apartments")){
    function search(){
        let distract=$("#distract").val();
        let search_txt = $("#search").val();
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('distract',distract);
        form_data.append('search_txt',search_txt);
        form_data.append('_token',_token);
        $.ajax({
            url: "/search_apartments",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                if(result.status=="unsuccess"){
                    $("#buildings").html(`<div class="col text-center">
                                                <div class="alert alert-danger">
                                                    ${result.result}
                                                </div>
                                            </div>`)
                }
                else{
                    $("#apartments").html("");
                    jQuery.each( result.apartments, function( i, apartment ) {
                        str=`<div class="col-auto">
                                <a class="txt-master" href="/apartment/${apartment.id}">
                                    <div class="row m-3">
                                        <div class="col-auto pl-0  text-right txt-master ">
                                            <i class="fas fa-building" style="font-size: 6rem"></i>
                                        </div>
                                        <div class="col text-right txt-master ">
                                            <p class="h2" id="name">${apartment.name}</p>
                                            <p class="txt-slave" id="description">${apartment.description}</p>
                                            <p class="txt-slave" id="floor_number">رقم الدور: <span class="txt-master" >${apartment.floor_number}</span></p>
                                            <p class="txt-slave" id="room_number">عدد الغرف: <span class="txt-master" >${apartment.room_number}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>`;
                        $("#apartments").append(str);
                    });
                }
            }
        });
    }
}
//add apartment page
if(page.includes("/add_apartment") || page.includes("/apartment/")){
    // $(function(){
        $('#attachments').on('change' , attach_changed);
        function attach_changed(){
            if(document.querySelector('#attachments').files.length>0){
                var curFiles=document.querySelector('#attachments').files;
                // $('label.custom-file-label[for="offer_img"]').addClass("txt-master");
                jQuery.each( curFiles, function( i, curFile ) {
                    if (validFileType(curFile)){

                        $('label.custom-file-label[for="attachments"]').text(`عدد المرفقات ${i+1}`);
                    }
                    else{
                        swal.fire({
                            title: 'صيغة الملف غير مدعومة',text: 'الصيغ المدعومة: images ',icon:'error',
                        });
                        $('#attachments').val('');

                    }
                });
            }
            else{
                $('label.custom-file-label[for="attachments"]').removeClass("txt-master").text('اختر صور الشقة');
            }
        }
        var fileTypes = [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif'
            // 'application/pdf'//,
            //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            //'application/vnd.ms-excel'
        ];

        function validFileType(file) {
            for (var i = 0; i < fileTypes.length; i++) {
                if (file.type === fileTypes[i]) {
                    return true;
                }
            }
            return false;
        };
    // });
}
//add apartment page
if(page.includes("/add_apartment")){
    function add_apartment(){
        if($("#name").val()=="" || $("#building").val()=="" || $("#rent_val").val()==""){
            swal.fire("استمكل البيانات"," اكتب اسم الشقة واختر العمارة والإيجار","info");
        }
        else{
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var name=$('#name').val();
            var description=$('#description').val().trim();
            var floor_number=$('#floor_number').val().trim();
            var room_number=$('#room_number').val().trim();
            var building_id=$('#buildings').val().trim();
            var electric_id=$('#electric_id').val().trim();
            var rent_val=$('#rent_val').val().trim();
            var form_data=new FormData();
            form_data.append('name',name);
            form_data.append('description',description);
            form_data.append('room_number',room_number);
            form_data.append('floor_number',floor_number);
            form_data.append('building_id',building_id);
            form_data.append('electric_id',electric_id);
            form_data.append('rent_val',rent_val);
            form_data.append('_token',_token);
            var files=$('#attachments').prop('files');
            jQuery.each( files, function( i, v ) {
                form_data.append('attachments[]', v);
            });
            $.ajax({
                url: "/add_apartment",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    if(result=='success'){
                        swal.fire("تم بنجاح","حفظ البيانات",result);
                    }
                    else if(result=='info'){
                        swal.fire("خطأ في البيانات","الاسم مكرر",result);
                    }
                    else{
                        swal.fire(result.title,result.message,result.icon);
                    }
                    $("#name , #description , #floor_number , #room_number , #electric_id, #rent_val").val("");
                    $('.background').hide();
                }
            })
        }
    }
}

//renter page
if(page.includes("/add_renter")){
    $(function(){
        $('#attachment').on('change' , function(){
            if(document.querySelector('#attachment').files.length>0){
                var curFiles=document.querySelector('#attachment').files;
                $('label.custom-file-label[for="attachment"]').addClass("txt-master");
                if (validFileType(curFiles[0])){
                    $('label.custom-file-label[for="attachment"]').text(curFiles[0].name);
                }
                else{
                    swal.fire({
                        title: 'صيغة الملف غير مدعومة',text: 'الصيغ المدعومة: PDF',icon:'error',
                    });
                    $('#attachment').val('');

                }
            }
            else{
                $('label.custom-file-label[for="attachment"]').removeClass("txt-master").text('اختر هوية المستأجر');
            }
        });
        var fileTypes = [
            // 'image/jpeg',
            // 'image/pjpeg',
            // 'image/png',
            // 'image/gif'
            'application/pdf'//,
            //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            //'application/vnd.ms-excel'
        ];

        function validFileType(file) {
            for (var i = 0; i < fileTypes.length; i++) {
                if (file.type === fileTypes[i]) {
                    return true;
                }
            }
            return false;
        };
        $("#phone").on("input change onpaste" , function(){
            $(this).val(is_number($(this).val()));
        });
        $("#id_number").on("input onpaste" , function(){
            $(this).val(is_number($(this).val()));
            if($(this).val().length == 10){
                $('.background').show();
                var _token = $('input[name="_token"]').val().trim();
                var form_data=new FormData();
                form_data.append('_token',_token);
                $.ajax({
                    url: `/renterExists/${$(this).val()}`,
                    contentType: false,
                    enctype: "multipart/form-data",
                    processData: false,
                    method: "POST",
                    data: form_data ,
                    success: function (result) {
                        $("#name , #phone").parent().removeClass("d-none");
                        $('.background').hide();
                        if(result == 'not_exists'){
                            $("#attachment").parent().removeClass("d-none");
                            $("#name , #phone").attr("disabled",false);
                            $("#btn_next").parent().parent().remove();
                            $("#btn_add").parent().parent().remove();
                            str=`<div class="row m-4">
                                    <div class="col-lg-6 col-12 ml-auto mr-auto text-center">
                                        <button type="button" class="btn btn-primary" id="btn_add">إضافة</button>
                                    </div>
                                </div>`;
                            $("#attachment").parent().parent().after(str);
                        }
                        else{
                            $("#btn_next").parent().parent().remove();
                            $("#attachment").parent().addClass("d-none");
                            $("#btn_add").parent().parent().remove();
                            str=`<div class="row m-4">
                                    <div class="col-lg-6 col-12 ml-auto mr-auto text-center">
                                        <button type="button" class="btn btn-success" id="btn_next">متابعة</button>
                                    </div>
                                 </div>`;
                            $("#attachment").parent().parent().after(str);
                            $("#name , #phone").attr("disabled",true);
                            $("#name").val(result.renter.name);
                            $("#phone").val(result.renter.phone_number);
                        }
                        $("#btn_add").on("click" , add_renter);
                        $("#btn_next").on("click" , next);
                        $("body").getNiceScroll().resize();
                    }
                });
            }
            else{
                $("#name , #phone").parent().addClass("d-none");
                $("#attachment").parent().addClass("d-none");
                $("#name , #phone").attr("diabled",false);
            }
        });
        function next(){
            window.location.assign(`/contract/renter_id_number/${$("#id_number").val()}`);
        }
        function add_renter(){
            if($("#name").val() == "" || $("#phone").val() == "" || $("#attachment").val() == ""){
                swal.fire("استكمل البيانات" , "الرجاء استكمال كافة البيانات" , "info");
                return;
            }
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('name',$("#name").val());
            form_data.append('phone',$("#phone").val());
            form_data.append('id_number',$("#id_number").val());
            form_data.append('attachment', $('#attachment').prop('files')[0]);
            $.ajax({
                url: `/add_renter`,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    if(result == 'success'){
                        swal.fire("تم بنجاح" , "حفظ البيانات" , "success");
                        str=`<div class="row m-4">
                                    <div class="col-lg-6 col-12 ml-auto mr-auto text-center">
                                        <button type="button" class="btn btn-success" id="btn_next">متابعة</button>
                                    </div>
                                 </div>`;
                            $("#attachment").parent().parent().after(str);
                            $("#btn_next").on("click" , next);
                            $("#btn_add").parent().parent().remove();
                            $("#name , #phone").attr("diabled",false);
                            $("#attachment").parent().parent().addClass("d-none");
                    }
                    else{
                        swal.fire(result.title , result.message , result.icon);
                    }
                    $('.background').hide();
                }
            });
        }
    });

}
//contract page
if(page.includes('/contract')){
    function save_pay_repeat(){
        var pay_repeat=$("#pay_repeat").val();
        if(pay_repeat == ""){
            swal.fire("استكمال البيانات", "الرجاء اختيار استحقاق الدفعات", "error");
            return;
        }
        var current_url = window.location.pathname;
        var id = current_url.split("/");
        id=id[id.length-1];
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $(".background").html("");
        $.ajax({
            url: `/update_pay_repeat/${id}/${pay_repeat}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                hide_pay_repeat();
            }
        });
    }
    function hide_pay_repeat(){
        $("div.background").css("display","none");
    }
    $("#building").on("change" , function(){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: `/get_avialable_apartments/${$(this).val()}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                str=``;
                jQuery.each( result.apartments, function( i, apartment ) {
                    str+=`<option value="${apartment.id}">${apartment.name}</option>`;
                });
                $("#apartment").html(str);
                $(".selectpicker").selectpicker("refresh");
                $('.background').hide();
            }
        });
    });
    $("#rent_unit").on("change" , function(){
        $("#hour").parent().parent().parent().remove();
        if($(this).val() == 'ساعة'){
            str=`<div class="row m-4">
                <div class="col-lg-3 col-6 mr-auto cus-input text-center">
                    <label for="hour" class="float-right">
                        * من الساعة
                    </label>
                    <select class="selectpicker w-100" title="الساعة" id="hour" data-live-search="true"
                    data-size="5" data-actions-box="true" >`;
            for(i=0; i<24; i++ ){
                str+=`<option value="${i}">`;
                if(i < 10){
                    str+=`0${i}`;
                }
                else{
                    str+=`${i}`;
                }
                str+=`</option>`;
            }
            str+=`</select>
                    </div>
                    <div class="col-lg-3 col-6 ml-auto cus-input text-center">
                        <label for="minutes" class="float-right">
                            * والدقيقة
                        </label>
                        <select class="selectpicker w-100" title="الدقيقة" id="minutes" data-live-search="true"
                        data-size="5" data-actions-box="true" >`;
            for(i=0; i<60; i++ ){
                str+=`<option value="${i}">`;
                if(i < 10){
                    str+=`0${i}`;
                }
                else{
                    str+=`${i}`;
                }
                str+=`</option>`;
            }
            str+=`</select>
                    </div>
                </div>`;
            $(this).parent().parent().parent().after(str);
            $(".selectpicker").selectpicker("refresh");
            $("body").getNiceScroll().resize();
        }
    });
    $("#btn_save").click( function(){
        array=["renter" , "building" , "apartment" ,"rent_duration" , "rent_unit" ,
            "h_start_date" , "h_end_date" , "rent_amount", "hour" , "minutes" , "pay_repeat"];
        _continue=true;
        jQuery.each( array ,function( key , value){
            if($(`#${value}`).length > 0){
                if($(`#${value}`).val().trim() == ""){
                    swal.fire("استكمال البيانات" , "استكمل جميع البيانات المطلوبة" , "info");
                    _continue = false;
                }
            }
        });
        if(_continue){
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            var start_date= moment($("#h_start_date").val(), 'iYYYY/iM/iD').format('YYYY-M-D');
            var end_date= moment($("#h_end_date").val(), 'iYYYY/iM/iD').format('YYYY-M-D');
            form_data.append('_token',_token);
            form_data.append('start_date',start_date);
            form_data.append('end_date',end_date);
            jQuery.each( array ,function( key , value){
                if($(`#${value}`).length > 0){
                    form_data.append(value,$(`#${value}`).val());
                }
            });
            $.ajax({
                url: `/add_contract`,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    if($("#btn_save").hasClass("rent")){
                        window.location.assign(`/pay-contract/${result}`);
                    }
                    console.log(result);
                    swal.fire("تم بنجاح","حفط البيانات" ,"success");
                    $('.background').hide();
                    jQuery.each( array ,function( key , value){
                        if(value == "renter"){
                            return;
                        }
                        if($(`#${value}`).length > 0){
                            $(`#${value}`).val("");
                        }
                    });
                $(".selectpicker").selectpicker("refresh");
                }
            });
        }
    });
    $("#rent_amount").on("input" , function(){
        $(this).val(is_number($(this).val()));
    });
}
//login page
if(page.includes('/login/') || page.includes('/reset/')){
    $('#password').on('input', function(){
        var pwd=$('#password');
        if(pwd.val().length < 8){
            $('#pwd_error').text('كلمة المرور يجب أن تكون 8 أحرف وأرقام على الأقل!!!')
                            .addClass('text-center').removeClass('d-none');
        }
        else{
            $('#pwd_error').addClass('d-none');
            $( "#re_password" ).trigger( "input" );
        }
    });


    $('#re_password').on('input',function(){
        var pwd=$('#password');
        var re_pwd=$('#re_password');
        if(re_pwd.val().length < 8 || pwd.val() !== re_pwd.val() ){
            $('#re_pwd_error').text('كلمة المرور وتأكيدها لم تتطابق!!!')
                            .addClass('text-center').removeClass('d-none');
            $('#set_pwd_btn').prop('disabled',true);
        }
        else{
            $('#re_pwd_error').addClass('d-none');
            $('#set_pwd_btn').prop('disabled',false);
            $('#re_password').on('keypress',function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    $( "#set_pwd_btn" ).trigger( "click" );
                }
            });
        }
    });

    $('#set_pwd_btn').click(function(){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var pwd=$('#password').val();
        var email=$('#email').val().trim();
        var form_data=new FormData();
        form_data.append('pwd',pwd);
        form_data.append('email',email);
        form_data.append('_token',_token);
        $.ajax({
            url: "/set_pwd",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                if(result.success=='true'){
                    $('.background').hide();
                    swal.fire({
                        title: result.title,text: result.message,icon:"success",
                    });
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 2000);
                }
                else{
                    $('.background').hide();
                    swal.fire({
                        title: result.title,text: result.message,icon:"error",
                    });
                }
            }
        });
    })
}
//login page
if(page.includes('/login')){

    $('#password').on('input',function(){
        var pwd=$('#password');
        var email=$('#email').val();
        if(pwd.val().length >= 8 && email.trim()!=''){
            $( "#login_btn" ).prop('disabled',false);
        }
        else{
            $( "#login_btn" ).prop('disabled',true);
        }
    });
    $('#password').on('keyup',function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            var pwd=$('#password');
            var email=$('#email').val();
            if(pwd.val().length >= 8 && email.trim()!=''){
                $( "#login_btn" ).trigger( "click" );
            }
        }
    });
    $('#email').on('keypress',function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        var pwd=$('#password');
        var email=$('#email').val();
        if(pwd.val().length >= 8 && email.trim()!=''){
            $( "#login_btn" ).prop('disabled',false);
            if(keycode == '13'){
                $( "#login_btn" ).trigger( "click" );
            }
        }
        else{
            $( "#login_btn" ).prop('disabled',true);
        }
    });
    $("#login_btn").click(function(){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var pwd=$('#password').val();
        var email=$('#email').val().trim();
        var form_data=new FormData();
        form_data.append('pwd',pwd);
        form_data.append('email',email);
        form_data.append('_token',_token);
        $.ajax({
            url: "/login",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                if(result.success=='true'){
                    $('.background').hide();
                    swal.fire({
                        title: result.title,text: result.message,icon:"success",
                    });
                    setTimeout(function() {
                        window.location.href = result.url;
                    }, 2000);
                }
                else{
                    $('.background').hide();
                    swal.fire({
                        title: result.title,text: result.message,icon:"error",
                    });
                }
            }
        });
    })

}
//role page
if(page.includes('/roles')){

    $('#users').on('change',function(){
        $('.background').show();
        $('#roles').hide();
        var _token = $('input[name="_token"]').val().trim();
        var user_id=$(this).val();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: "/get_user_roles/"+user_id,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                jQuery.each( result.roles, function( i, val ) {
                    $('.form-check-input').each(function() {
                        if( this.value==val.id ){
                            $('#'+this.id).data('change',0);
                            $('#'+this.id).bootstrapToggle('on');
                            $('#'+this.id).data('change',1);
                        }
                        else{
                            $('#'+this.id).data('change',0);
                            $('#'+this.id).bootstrapToggle('off');
                            $('#'+this.id).data('change',1);
                        }
                    });
                });
                $('#roles').show();
                $('.background').hide();
            }
        });
    })
    function set_role(id){
        if($('#'+id).data('change')==1){
            $('.background').show();
            $('#result').html(result).hide();
            var _token = $('input[name="_token"]').val().trim();
            var enabled=$('#'+id).prop('checked')==true;
            var role=$('#'+id).val();
            var user_id=$('#users').val();
            var form_data=new FormData();
            form_data.append('_token',_token);
            $.ajax({
                url: "/set_user_roles/" + user_id + "/" + role + "/" + enabled,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('#result').html(result).removeClass('d-none').show();
                    $('.background').hide();
                    setTimeout(function() {
                        $('#result').fadeOut('slow');
                    }, 2000);
                }
            });
        }
    }
}
//new_user and users page
if(page.includes('/new_users') || page.includes('/users')){
    function set_active(id){
        $('.background').show();
        $('#result'+id).hide();
        var _token = $('input[name="_token"]').val().trim();
        var enabled=$('#user'+id).prop('checked')==true;
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: "/set_active/" + id + "/" + enabled,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                swal.fire({
                    title: result,icon:"success",
                }).then(function() {
                    $('.background').hide();
                    location.reload();
                });
            }
        });
    }
}

//reset_pwd page
if(page.includes('/pay-contract/')){
    $('#pay_btn').click(function(){
        if( $('#card_-number').val()=='' || $('#card-expiry').val()=='' || $('#cvv').val()==''){
            swal.fire({
                title: 'استكمال البيانات',text: 'استكمل جميع البيانات للمتابعة',icon:'error',
            });
        }
        else{
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('card_number',$('#card-number').val());
            form_data.append('card_expiry',$('#card-expiry').val());
            form_data.append('cvv',$('#cvv').val());
            $.ajax({
                url: `/pay-contract/${$('#contract_id').val()}`,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    swal.fire("تم","استقبال دفعتك","success").then(function(){
                        var win = window.open(`/summary/renter/${result.renter_id}`, '_blank');
                        if (win) {
                            //Browser has allowed it to be opened
                            win.focus();
                        } else {
                            //Browser has blocked it
                            swal.fire('تنبيه','تم حظر فتح النافذة','error');
                        }
                        // location.assign(`/`);
                    })

                }
            });
        }
    });
}
//reset_pwd page
if(page.includes('/reset_pwd')){
    $('#reset_btn').click(function(){
        $('.background').show();
        var email=$('#email').val();
        if(is_email(email)){
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            $.ajax({
                url: "/reset_pwd/" + email,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    var icon='error';
                    if(result.success=='true'){
                        icon="success";
                    }
                    swal.fire({
                        title: result.title,text: result.message,icon:icon,
                    });
                }
            });
        }
        else{
            swal.fire({
                title: 'خطأ',text: 'صيغة البريد الالكتروني خاطئة',icon:"error",
            });

            $('.background').hide();
        }
    })
    $('#email').on('keypress',function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $( "#reset_btn" ).trigger( "click" );
        }
    })
}
//add transaction page
if(page.includes('/add_transaction') || page.includes('/add_amount/contract/')){
    $('#amount').on('input change onpaste', function(){
        $('#amount').val(is_number($('#amount').val()));
    });
    $('#renter').on('change', function(){
        if($(this).val() != ""){
            $('.background').show();
            var renter_id = $(this).val();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            $.ajax({
                url: `/get_renter_apartments/${renter_id}`,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $("#apartment").html(result).selectpicker("refresh");
                }
            });
        }
    });

    $('#add_amount_btn').click(function(){
        if( $('#apartment').val()=='' || $('#renter').val()=='' || $('#description').val()=='' || $('#amount').val()=='' ){
            swal.fire({
                title: 'استكمال البيانات',text: 'استكمل جميع البيانات للمتابعة',icon:'error',
            });
        }
        else{
            $('.background').show();
            var renter = $('#renter').val();
            var amount = $('#amount').val();
            var apartment = $('#apartment').val();
            var contract_id = $('#contract_id').val();
            var description=$('#description').val();
            var notes=$('#notes').val();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('renter',renter);
            form_data.append('apartment',apartment);
            form_data.append('contract_id',contract_id);
            form_data.append('amount',amount);
            form_data.append('description',description);
            form_data.append('notes',notes);
            $.ajax({
                url: "/add_amount",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    if(result.success=='true'){
                        swal.fire({
                            title: 'تم بنجاح' , text: 'إضافة المبلغ إلى حساب المستأجر.' , icon: "success",
                        }).then(function() {
                            $('#amount').val('');
                            $('#description').val('');
                            $('#notes').val('');
                        });
                    }
                    else{
                        swal.fire({
                            title: 'عذراً' , text: result+'.' , icon: "error",
                        })
                    }
                }
            });
        }
    })
    $('#add_transaction_btn').click(function(){
        if( $('#apartment').val()=='' || $('#renter').val()=='' || $('#received_by').val()=='' || $('#description').val()=='' || $('#amount').val()=='' || $('#transaction_date').val()=='' ){
            swal.fire({
                title: 'استكمال البيانات',text: 'استكمل جميع البيانات للمتابعة',icon:'error',
            });
        }
        else{
            $('.background').show();
            var renter = $('#renter').val();
            var amount = $('#amount').val();
            var apartment = $('#apartment').val();
            var transaction_date=$('#transaction_date').val();
            var h_transaction_date=$('#h_transaction_date').val();
            var description=$('#description').val();
            var received_by=$('#received_by').val();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('renter',renter);
            form_data.append('apartment',apartment);
            form_data.append('amount',amount);
            form_data.append('received_by',received_by);
            form_data.append('transaction_date',transaction_date);
            form_data.append('hijri_transaction_date',h_transaction_date);
            form_data.append('description',description);
            $.ajax({
                url: "/add_transaction",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    if(result.success=='true'){
                        swal.fire({
                            title: 'تم بنجاح' , text: 'إضافة الدفعة إلى حساب المستأجر.' , icon: "success",
                        }).then(function() {
                            window.open(`/print-transaction/${result.transaction_id}/print`, '_blank');
                            $('#amount').val('');
                            $('#transaction_date').val('');
                            $('#h_transaction_date').val('');
                            $('#description').val('');
                            $('#received_by').val('').change();
                            if(!$("button[data-id='apartment']").hasClass("disabled")){
                                $('#apartment').val('').change();
                                $('#renter').val('').change();
                            }
                        });
                    }
                    else{
                        swal.fire({
                            title: 'عذراً' , text: result+'.' , icon: "error",
                        })
                    }
                }
            });
        }
    })
    var fileTypes = [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif'
        //'application/pdf'//,
        //'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //'application/vnd.ms-excel'
    ];

    function validFileType(file) {
        for (var i = 0; i < fileTypes.length; i++) {
            if (file.type === fileTypes[i]) {
                return true;
            }
        }
        return false;
    };
    $("#h_transaction_date").on('dp.change dp.update dp.hide', function () {
        var val=$(this).val();
        if(val!=""){
            var m = moment(val, 'iYYYY/iM/iD'); // Parse a Hijri date.
            $('#transaction_date').val(m.format('YYYY-MM-DD'));
        }
        else{
            $('#transaction_date').val("");
        }
    });
}
if(page.includes('/show_transactions')){
    var from_format=false;
    var to_format=false;


    function search(){
        if(($("#from_date").val().trim() != '' && $("#to_date").val().trim() != '') || $('#users').val() != ''){
            var from_date=$("#from_date").val();
            var to_date=$("#to_date").val();
            if(from_format){
                var m = moment(from_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                from_date=(m.format('YYYY-MM-DD'));
            }
            if(to_format){
                var m = moment(to_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                to_date=(m.format('YYYY-MM-DD'));
            }
            $('.background').show();
            var users=$('#users').val();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('from_date',from_date);
            form_data.append('to_date',to_date);
            form_data.append('users',users);
            $.ajax({
                url: "/get_transactions",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $('#transactions').html(result);
                    $("body").getNiceScroll().resize();
                }
            })
        }
        else{
            swal.fire({
                title: 'عذراً' , text:'اختر التاريخ أو المستخدم.' , icon: "error",
            })
        }
    }
    function unapproved(){
        $('.background').show();
        $('#from_date').val('');
        $('#to_date').val('');
        $('#users.selectpicker').selectpicker('val', '');
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: "/get_unapproved_transactions",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                $('#transactions').html(result);
                $("body").getNiceScroll().resize();
            }
        })
    }

}
if(page.includes('/show_transactions') || page.includes('/my_balance')){
    function change_transaction(id){
        let str="رفض";
        var val=$('input[name="control'+id+'"]:checked').val();
        if(val==1){
            str="قبول";
        }
        swal.fire({
            title: 'متابعة التنفيذ' ,
            text:`سيتم ${str} الدفعة هل تريد المتابعة؟` ,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'متابعة',
            cancelButtonText: 'إلغاء الأمر'
          }).then((result) => {
            if (result.value && val!=1) {
                swal.fire({
                    title: 'اذكر سبب الرفض',
                    input: 'text'
                }).then(function (text) {
                    if(text.value==""){
                        $('input[name="control'+id+'"]:checked').prop("checked",false);
                        return swal.fire({
                            title:"أضف سبب الرفض",
                            text: "لا يمكنك ترك سبب الرفض فارغاً أعد المحاولة!!!",
                            icon:"error"
                        });

                    }
                    $('.background').show();
                    var _token = $('input[name="_token"]').val().trim();
                    var form_data=new FormData();
                    form_data.append('_token',_token);
                    form_data.append('val',val);
                    form_data.append('id',id);
                    form_data.append('text',text.value);
                    $.ajax({
                        url: "/change_transaction",
                        contentType: false,
                        enctype: "multipart/form-data",
                        processData: false,
                        method: "POST",
                        data: form_data ,
                        success: function (result) {
                            $('.background').hide();
                            if(result=='true'){
                                swal.fire({
                                    title: 'تم بنجاح' , text:'حفظ البيانات.' , icon: "success",
                                })
                            }
                            if(result=="same_user"){
                                swal.fire("عذراً","لا يمكنك قبول أو رفض دفعاتك","error");
                                $('input[name="control'+id+'"]:checked').prop("checked",false);
                            }
                        }
                    });
                });
            }
            else if(result.value){
                $('.background').show();
                var _token = $('input[name="_token"]').val().trim();
                var form_data=new FormData();
                form_data.append('_token',_token);
                form_data.append('val',val);
                form_data.append('id',id);
                $.ajax({
                    url: "/change_transaction",
                    contentType: false,
                    enctype: "multipart/form-data",
                    processData: false,
                    method: "POST",
                    data: form_data ,
                    success: function (result) {
                        $('.background').hide();
                        if(result=='true'){
                            swal.fire({
                                title: 'تم بنجاح' , text:'حفظ البيانات.' , icon: "success",
                            })
                        }
                        if(result=="same_user"){
                            swal.fire("عذراً","لا يمكنك قبول أو رفض دفعاتك","error");
                            $('input[name="control'+id+'"]:checked').prop("checked",false);
                        }
                    }
                });
            }
            else {
                $('input[name="control'+id+'"]:checked').prop("checked",false);
            }
        })
    }
    function toggle_img(id){
        $('#tr'+id).toggleClass('d-none');
        $('#i'+id).toggleClass('fa-eye fa-eye-slash');
        if($('#tr'+id).hasClass('d-none')){
            $('#i'+id).attr('title','إظهار الإيصال');
        }
        else{
            $('#i'+id).attr('title','إخفاء الإيصال');
        }
        $("body").getNiceScroll().resize();
    }
    $("#from_date").on('dp.change dp.update dp.hide', function () {
        from_format=($(this).data().HijriDatePicker.hijri());
    });
    $("#to_date").on('dp.change dp.update dp.hide', function () {
        to_format=($(this).data().HijriDatePicker.hijri());
    });
}
if(page.includes('/my_balance')){
    function search(){
        if($("#from_date").val().trim() != '' && $("#to_date").val().trim() != ''){
            var from_date=$("#from_date").val();
            var to_date=$("#to_date").val();
            if(from_format){
                var m = moment(from_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                from_date=(m.format('YYYY-MM-DD'));
            }
            if(to_format){
                var m = moment(to_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                to_date=(m.format('YYYY-MM-DD'));
            }
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('from_date',from_date);
            form_data.append('to_date',to_date);
            $.ajax({
                url: "/get_my_transactions",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $('#transactions').html(result);
                    $("body").getNiceScroll().resize();
                }
            })
        }
        else{
            swal.fire({
                title: 'عذراً' , text:'اختر التاريخ أو المستخدم.' , icon: "error",
            })
        }
    }
}

if(page.includes('/conf')){
    function edit_control(name){
        $('#'+name).attr('disabled',!$('#'+name).attr('disabled'))
        .focus();
    }
    function save_config(){
        var fee=$('#fee').val();
        var min=$('#min').val();
        var max=$('#max').val();
        var iban=$('#iban').val();
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        form_data.append('fee',fee);
        form_data.append('min',min);
        form_data.append('max',max);
        form_data.append('iban',iban);
        $.ajax({
            url: "/save_config",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                $('#result').removeClass().addClass(result.class).html(result.message);
                $('.btn.btn-link').show();
                if(!$('#fee').attr('disabled'))
                    edit_control('fee');
                if(!$('#min').attr('disabled'))
                    edit_control('min');
                if(!$('#max').attr('disabled'))
                    edit_control('max');
                if(!$('#iban').attr('disabled'))
                    edit_control('iban');
            }
        })
    }
}
if(page.includes("/sponsor_orders")){
    function response_sponsor_order(object , loan_id , value){
        swal.fire({
                    title: `${value} طلب الكفالة` ,
                    text:`سيتم ${value} طلب الكفالة هل تريد المتابعة؟` ,
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'متابعة',
                    cancelButtonText: 'إلغاء الأمر'
                }).then((result) => {
                    if (result.value) {
                        $('.background').show();
                        var _token = $('input[name="_token"]').val().trim();
                        var form_data=new FormData();
                        form_data.append('_token',_token);
                        form_data.append('loan_id',loan_id);
                        form_data.append('value',value);
                        $.ajax({
                            url: "/response_sponsor_order",
                            contentType: false,
                            enctype: "multipart/form-data",
                            processData: false,
                            method: "POST",
                            data: form_data ,
                            success: function (result) {
                                var p=object.parentNode.parentNode;
                                if($(p.parentNode).children().length==1){
                                    $(".table-responsive").after(
                                    `<div class="alert alert-info text-center mt-5">لا يوجد بيانات</div>`
                                    );
                                    $(".table-responsive").remove();

                                }
                                let count=parseInt($('#sponsor_orders_count .badge.badge-pill.badge-danger').text())-1;
                                $('#sponsor_orders_count .badge.badge-pill.badge-danger').text(count);
                                count=parseInt($('#loans .badge.badge-pill.badge-danger').text())-1;
                                $('#loans .badge.badge-pill.badge-danger').text(count);
                                p.parentNode.removeChild(p);
                                $('.background').hide();
                                swal.fire("تم بنجاح",`${value} طلب الكفالة`,"success");
                            }
                        })
                    }
                })

    }
}
if(page.includes('/order_loan')){
    function check_amount(amount){
        var balance=$('#my_balance').val();
        if( amount > balance*2 || amount=='' || amount <= 0 ){
            swal.fire({
                title: 'عذراً' , text:'المبلغ المسموح لك هو '+balance*2+'.' , icon: "error",
            })
            $('#sponsor').html('');
            $('.selectpicker').selectpicker('refresh');
            $('#monthly_payment_agreement').addClass('d-none');
            $('label[for="monthly_payment_agreement"]').addClass('d-none');
            return;
        }
        else if(amount > 300000){
            swal.fire({
                title: 'عذراً' , text:'تجاوزت الحد الأعلى المسموح للقرض (300000) ريال.' , icon: "error",
            })
            $('#sponsor').html('');
            $('.selectpicker').selectpicker('refresh');
            $('#monthly_payment_agreement').addClass('d-none');
            $('label[for="monthly_payment_agreement"]').addClass('d-none');
            return;
        }
        else {
            var monthly_payment=0;
            $('.background').show();
            if(amount < 30000){
                monthly_payment=1000;
            }
            else if(amount > 30000 && amount < 60000){
                monthly_payment=1500;
            }else if(amount > 60000 && amount < 90000){
                monthly_payment=2000;
            }
            else if(amount > 90000 && amount < 120000){
                monthly_payment=2500;
            }
            else if(amount > 120000 && amount < 150000){
                monthly_payment=3000;
            }
            else if(amount > 150000 && amount < 180000){
                monthly_payment=3500;
            }
            else if(amount > 180000 && amount < 210000){
                monthly_payment=4000;
            }
            else if(amount > 210000 && amount < 240000){
                monthly_payment=4500;
            }
            else if(amount > 240000 && amount < 270000){
                monthly_payment=5000;
            }
            else if(amount > 270000 && amount < 300000){
                monthly_payment=5500;
            }
            $('#monthly_payment').html(monthly_payment);
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            $.ajax({
                url: "/get_sponsor/"+amount,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $('#sponsor').html(result);
                    $('.selectpicker').selectpicker('refresh');
                    $('#monthly_payment_agreement').removeClass('d-none');
                    $('label[for="monthly_payment_agreement"]').removeClass('d-none');
                }
            })
        }
    }
    function add_loan(){
        if($('#amount').val()=='' || $('#sponsor').val()==''){
            swal.fire({
                title: 'الرجاء' , text:'استكمال البيانات' , icon: "error",
            })
        }
        else {
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('amount',$('#amount').val());
            form_data.append('sponsor',$('#sponsor').val());
            form_data.append('monthly_payment',$('#monthly_payment').text());
            $.ajax({
                url: "/add_loan",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    var icon='error';
                    if(result.success=='true'){
                        icon="success";
                    }
                    swal.fire({
                        title: result.title,text: result.message,icon:icon,
                    }).then(function(){
                        window.location.reload();
                    });
                }
            })
        }
    }
    function monthly_payment_changed(){
        if($('#monthly_payment_agreement').is(':checked')){
            $('button.btn.btn-gold').attr('disabled',false);
        }
        else{
            $('button.btn.btn-gold').attr('disabled',true);
        }
    }
    $( window  ).ready(function() {
        monthly_payment_changed();
    })
}
if(page.includes('/loans')){
    let from_format=false;
    let to_format=false;

    function search(){
        if(($("#from_date").val().trim() != '' && $("#to_date").val().trim() != '') || $('#users').val() != ''){
            $('.background').show();
            var from_date=$("#from_date").val();
            var to_date=$("#to_date").val();
            if(from_format){
                var m = moment(from_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                from_date=(m.format('YYYY-MM-DD'));
            }
            if(to_format){
                var m = moment(to_date, 'iYYYY/iM/iD'); // Parse a Hijri date.
                to_date=(m.format('YYYY-MM-DD'));
            }
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token' , _token);
            form_data.append('user_id' , $('#users').val() );
            form_data.append('from_date',from_date);
            form_data.append('to_date',to_date);
            $.ajax({
                url: "/get_user_loans",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $("#loans_table").html(result);
                }
            })
        }
        else{
            swal.fire({
                title: 'عذراً' , text:'اختر التاريخ أو المستخدم.' , icon: "error",
            })
        }
    }
    $("#from_date").on('dp.change dp.update dp.hide', function () {
        from_format=($(this).data().HijriDatePicker.hijri());
    });
    $("#to_date").on('dp.change dp.update dp.hide', function () {
        to_format=($(this).data().HijriDatePicker.hijri());
    });
}
//page loan
if(page.includes('/loan/')){
    $("div.row div.col.mt-3.text-center button.btn.btn-gold").on("click", function(){
        if($("#sponsor").val()==""){
            swal.fire("استكمال البيانات" , "اختر الكفيل للاستمرار" , "error");
        }
        else{
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('loan_id',$('#loan_id').val());
            form_data.append('sponsor_id',$('#sponsor').val());
            $.ajax({
                url: "/update_sponsor",
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $(".table-responsive").next().remove();
                    $("#sponsor_approve").html(`<i class="fas fa-circle" style="color: gray"></i> قيد الاعتماد`);
                    swal.fire(result.title , result.message , "success");
                }
            })
        }
    })
    function response_sponsor_order(object , loan_id , value){
        swal.fire({
                    title: `${value} طلب الكفالة` ,
                    text:`سيتم ${value} طلب الكفالة هل تريد المتابعة؟` ,
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'متابعة',
                    cancelButtonText: 'إلغاء الأمر'
                }).then((result) => {
                    if (result.value) {
                        $('.background').show();
                        var _token = $('input[name="_token"]').val().trim();
                        var form_data=new FormData();
                        form_data.append('_token',_token);
                        form_data.append('loan_id',loan_id);
                        form_data.append('value',value);
                        $.ajax({
                            url: "/response_sponsor_order",
                            contentType: false,
                            enctype: "multipart/form-data",
                            processData: false,
                            method: "POST",
                            data: form_data ,
                            success: function (result) {
                                let count=parseInt($('#sponsor_orders_count .badge.badge-pill.badge-danger').text())-1;
                                $('#sponsor_orders_count .badge.badge-pill.badge-danger').text(count);
                                count=parseInt($('#loans .badge.badge-pill.badge-danger').text())-1;
                                $('#loans .badge.badge-pill.badge-danger').text(count);
                                $('.background').hide();
                                swal.fire("تم بنجاح",`${value} طلب الكفالة`,"success");
                            }
                        })
                    }
                })

    }
    function response__order(object , loan_id , value){
        swal.fire({
            title: `${value} طلب القرض` ,
            text:`سيتم ${value} طلب القرض هل تريد المتابعة؟` ,
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'متابعة',
            cancelButtonText: 'إلغاء الأمر'
        }).then((result) => {
            if (result.value) {
                $('.background').show();
                var _token = $('input[name="_token"]').val().trim();
                var form_data=new FormData();
                form_data.append('_token',_token);
                form_data.append('loan_id',loan_id);
                form_data.append('value',value);
                $.ajax({
                    url: "/response__order",
                    contentType: false,
                    enctype: "multipart/form-data",
                    processData: false,
                    method: "POST",
                    data: form_data ,
                    success: function (result) {
                        $('.background').hide();
                        let color="red";
                        let approve="مرفوض";
                        if(value=="قبول"){
                            color="green";
                            approve="مقبول";
                        }
                        str=`<i class="fas fa-circle" style="color: ${color}"></i> ${approve}`;
                        $("#sponsor_approve").next().html(str);

                        $("#buttons_loan_approved").remove();
                        swal.fire("تم بنجاح",`${value} طلب القرض`,"success");
                    }
                })
            }
        })
    }
}
//page balance
if(page.includes("/balance")){
    function search(){
        let user=$("#users").val();
        if(user == ""){
            swal.fire("استكمال البيانات" , "الرجاء اختيار المستخدم" , "error");
            return 0;
        }
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: `/get_balance/${user}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $("#row").html(result);
                initHijrDatePickerDefault();
                $("body").getNiceScroll().resize();
                $('.background').hide();
            }
        })
    }
}
//building page
if(page.includes("/building/")){
    function show_edit(){
        var name, description, address, address_url, notes;
        name = $("#building_name").val();
        description = $("#building_description").val();
        address = $("#building_address").val();
        address_url = $("#building_address_url").val();
        notes = $("#building_notes").val();
        distracts = JSON.parse($("#distracts").val());
        var str=`
        <div class="title h3 font-weight-bold">
            تعديل بيانات العمارة
        </div>
        <div class="col-9 ml-auto mr-auto">
            <div class="row">
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_name">
                        * اسم العمارة
                    </label>
                    <input type="text" id="tmp_name" class="form-control w-100 text-center mb-3" value="${name}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_desc">
                        وصف العمارة
                    </label>
                    <input type="text" id="tmp_desc" class="form-control w-100 text-center mb-3" value="${description}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_address">
                        موقع العمارة
                    </label>
                    <input type="text" id="tmp_address" class="form-control w-100 text-center mb-3" value="${address}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_address_url">
                        الموقع في خرائط جوجل
                    </label>
                    <input type="text" id="tmp_address_url" class="form-control w-100 text-center mb-3" value="${address_url}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_notes">
                        الملاحظات
                    </label>
                    <input type="text" id="tmp_notes" class="form-control w-100 text-center mb-3" value="${notes}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="distract">
                        *الحي
                    </label>
                    <select class="w-100 mb-4 my-select" style="width:100% !important; height:2.5rem;border-radius:5px;" title="اختر الحي" id="temp_distract">`;
                    jQuery.each( distracts, function( i, distract ) {
                        str+=`<option value="${distract.id}"`;
                        if(distract.name == $("#distract").text())
                            str+=` selected`;
                        str+=`>${distract.name}</option>`;
                    });
        str+=`</select>
                </div>
                <div class="col-6 text-center mb-3">
                    <button class="btn btn-success" onclick="btn_save_building();">حفظ</button>
                </div>
                <div class="col-6 text-center mb-3">
                    <button class="btn btn-danger" onclick="btn_cancel();">إلغاء الأمر</button>
                </div>
            </div>
        </div>`;
        $("#edit").removeClass("d-none animate__fadeOut").show();
        $("#edit .edit").addClass("animate__backInUp").html(str);
        $(".selectpicker").selectpicker("refresh");
    }
    function btn_save_building(){
        if($("#tmp_name").val()==""){
            swal.fire("استكمال البيانات", "الرجاء تسجيل اسم العمارة" ,"info");
            return;
        }
        $('#background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        var current_url = window.location.pathname;
        var id = current_url.split("").pop();
        var name = $("#tmp_name").val();
        var description = $("#tmp_desc").val();
        var address = $("#tmp_address").val();
        var address_url = $("#tmp_address_url").val();
        var notes = $("#tmp_notes").val();
        var distract = $("#temp_distract").val();
        form_data.append('name',name);
        form_data.append('description',description);
        form_data.append('address',address);
        form_data.append('notes',notes);
        form_data.append('distract',distract);
        form_data.append('address_url',address_url);
        $.ajax({
            url: `/update_building/${id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                if( result.success == "true"){
                    swal.fire("تم بنجاح" , "حفظ البيانات" , "success");
                    $("#name").text(name);
                    $("#description").text(description);
                    $("#address").text(address);
                    if(address_url != ""){
                        txt=`<a href="${address_url}" target="_blank" title="العنوان في خرائط جوجل">اضغط هنا للانتقال للرباط في خرائط جوجل</a>`;
                        $("#address_url").html(txt);
                    }
                    else{
                        $("#address_url").text("");
                    }
                    $("#notes").text(notes);
                    $("#building_name").val(name);
                    $("#building_description").val(description);
                    $("#building_address").val(address);
                    $("#building_address_url").val(address_url);
                    $("#building_notes").val(notes);
                    $("#distract").html($("#temp_distract option:selected").text());
                    btn_cancel();
                }
                else{
                    swal.fire(result.title , result.message , "error");
                }
                $('#background').hide();
            }
        })
    }
    function btn_cancel(){
        $("#edit .edit").removeClass("animate__backInUp").html("");
        $("#edit").addClass("animate__fadeOut");
    }
    function delete_building(id){
        message="هل أنت متأكد من حذف العمارة؟";
        swal.fire({
            title: "تنبيه",
            html: message,
            icon: "error",
            // iconHtml: '؟',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'حذف',
            cancelButtonText:'إلغاء الأمر'
        })
        .then((result) => {
            if (result.value) {
                console.log(id);
            }
        });
    }
}

//request page
if(page.includes("/request/apartment/")){
    function request_maintanance(){
        var apartment_id = $("#apartment_id").val();
        var selected_date = $("#selected_date").val();
        var time = $(".times.btn-success").text();
        var request_type = document.querySelector('input[name="request_type"]:checked').value;
        var description = $("#request_description").val().trim();
        if(apartment_id == "" || selected_date == "" || time == "" || request_type == "" || description == ""){
            return swal.fire("نأمل","استكمال البيانات","info");
        }
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        form_data.append('selected_date',selected_date);
        form_data.append('time',time);
        form_data.append('request_type',request_type);
        form_data.append('description',description);
        $.ajax({
            url: `/request/apartment/${apartment_id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                swal.fire("تنبيه","تم رفع طلبك بنجاح يمكنك معرفة حالة الطلب بالذهاب إلى تبويب طلبات الصيانة","success")
                .then(function(){
                    location.assign("/requests");
                });
            }
        });
    }
}
if(page.includes("/requests")){
    function complate_request(obj , request_id){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);$.ajax({
            url: `/complate_request/${request_id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                $(obj).parent().parent().find('td:contains("غير مكتمل")').text("مكتمل");
            }
        });
    }
}
//appointment page
if(page.includes("/book_appointment/apartment/")){
    function book_appointment(){
        var apartment_id = $("#apartment_id").val();
        var selected_date = $("#selected_date").val();
        var time = $(".times.btn-success").text();
        if(apartment_id == "" || selected_date == "" || time == ""){
            return swal.fire("نأمل","استكمال البيانات","info");
        }
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        form_data.append('selected_date',selected_date);
        form_data.append('time',time);
        $.ajax({
            url: `/book_appointment/apartment/${apartment_id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                swal.fire("تنبيه","تم حفظ الموعد بنجاح نأمل عدم التأخير عن الموعد المحدد يمكنك رؤية تفاصيل الموعد من خلال الضغط على تبويب المواعيد","success")
                .then(function(){
                    location.assign("/appointments");
                });
            }
        });
    }
}
//apartment page
if(page.includes("/apartment/")){
    function select_this(obj){
        $(".times").removeClass("btn-success");
        $(obj).addClass("btn-success");
    }
    function emptying(id){
        swal.fire({
            title: 'متابعة التنفيذ' ,
            text:`سيتم إخلاء الشقة هل تريد المتابعة؟` ,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'متابعة',
            cancelButtonText: 'إلغاء الأمر'
          }).then((result) => {
            if (result.value) {
                $('.background').show();
                var _token = $('input[name="_token"]').val().trim();
                var form_data=new FormData();
                form_data.append('_token',_token);
                $.ajax({
                    url: `/emptying/${id}`,
                    contentType: false,
                    enctype: "multipart/form-data",
                    processData: false,
                    method: "POST",
                    data: form_data ,
                    success: function (result) {
                        $('.background').hide();
                        if(result=='true'){
                            swal.fire({
                                title: 'تم بنجاح' , text:'إخلاء الشقة.' , icon: "success",
                            }).then(function() {location.reload();})
                        }
                        else{
                            swal.fire({
                                title: result.title , text:result.message , icon: "danger",
                            })
                        }
                    }
                });
            }
        });
    }
    function show_edit(){
        var name,rent_val, description, floor_number, room_number, electric_id;
        name = $("#apartment_name").val();
        rent_val = $("#apartment_rent_val").val();
        description = $("#apartment_description").val();
        floor_number = $("#apartment_floor_number").val();
        room_number = $("#apartment_room_number").val();
        electric_id = $("#apartment_electric_id").val();
        var str=`
        <div class="title h3 font-weight-bold">
            تعديل بيانات الشقة
        </div>
        <div class="col-9 ml-auto mr-auto">
            <div class="row">
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_name">
                        * اسم الشقة
                    </label>
                    <input type="text" id="tmp_name" class="form-control w-100 text-center mb-3" value="${name}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_desc">
                        وصف الشقة
                    </label>
                    <input type="text" id="tmp_desc" class="form-control w-100 text-center mb-3" value="${description}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_rent_val">
                        *قيمة الإيجار
                    </label>
                    <input type="text" id="tmp_rent_val" class="form-control w-100 text-center mb-3" value="${rent_val}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_electric_id">
                        رقم حساب الكهرباء
                    </label>
                    <input type="text" id="tmp_electric_id" class="form-control w-100 text-center mb-3" value="${electric_id}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_floor_number">
                        رقم الدور
                    </label>
                    <input type="text" id="tmp_floor_number" class="form-control w-100 text-center mb-3" value="${floor_number}" />
                </div>
                <div class="col-6">
                    <label class="txt-bg font-weight-bold w-100 text-center" for="tmp_room_number">
                        عدد الغرف
                    </label>
                    <input type="text" id="tmp_room_number" class="form-control w-100 text-center mb-3" value="${room_number}" />
                </div>
                <div class="col-12 mb-3">
                    <label for="attachments" class="txt-bg font-weight-bold w-100 text-center">صور الشقة</label>
                    <input type="file" class="custom-file-input d-none" onchange="attach_changed();"
                        id="attachments" accept="image/*" multiple autocomplete="off" readonly="readonly">
                    <label class="custom-file-label w-100 mr-0" style="position:relative;" for="attachments">اختر صور الشقة</label>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-success" onclick="btn_save_apartment();">حفظ</button>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-danger" onclick="btn_cancel();">إلغاء الأمر</button>
                </div>
            </div>
        </div>
        `;
        $("#edit").removeClass("d-none animate__fadeOut").show();
        $("#edit .edit").removeClass("w-50 ").addClass("animate__backInUp").html(str);
    }

    function btn_save_apartment(){
        if($("#tmp_name").val()=="" || $("#tmp_rent_val").val()==""){
            swal.fire("استكمال البيانات", "استمكل البيانات المعلمة بنجمة" ,"info");
            return;
        }
        $('#background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        var current_url = window.location.pathname;
        var id = current_url.split("/");
        id=id[id.length-1];
        var name = $("#tmp_name").val();
        var rent_val = $("#tmp_rent_val").val();
        var description = $("#tmp_desc").val();
        var floor_number = $("#tmp_floor_number").val();
        var room_number = $("#tmp_room_number").val();
        var electric_id = $("#tmp_electric_id").val();
        form_data.append('name',name);
        form_data.append('rent_val',rent_val);
        form_data.append('description',description);
        form_data.append('floor_number',floor_number);
        form_data.append('room_number',room_number);
        form_data.append('electric_id',electric_id);
        var files=$('#attachments').prop('files');
        jQuery.each( files, function( i, v ) {
            form_data.append('attachments[]', v);
        });
        $.ajax({
            url: `/update_apartment/${id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                if( result.success == "true"){
                    var str="";
                    jQuery.each( result.files_img, function( i, img ) {
                        str+=`<div class="col-lg-6 col-12 p-2">
                                <img src="${img}" alt="imge${i+1}" class="rounded img-thumbnail" />
                            </div>`;
                    });
                    $("#files_img").html(str)
                    swal.fire("تم بنجاح" , "حفظ البيانات" , "success");
                    $("#rent_val span").text(rent_val);
                    $("#name").text(name);
                    $("#description span").text(description);
                    $("#floor_number span").text(floor_number);
                    $("#room_number span").text(room_number);
                    $("#electric_id span").text(electric_id);
                    $("#apartment_name").val(name);
                    $("#apartment_rent_val").val(rent_val);
                    $("#apartment_description").val(description);
                    $("#apartment_floor_number").val(floor_number);
                    $("#apartment_room_number").val(room_number);
                    $("#apartment_electric_id").val(electric_id);
                    btn_cancel();
                }
                else{
                    swal.fire(result.title , result.message , "error");
                }
                $('#background').hide();
            }
        })
    }
    function delete_img(apartment_id ,obj){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        var file = $(`.${obj}`).attr('src');
        form_data.append('file',file);
        $.ajax({
            url: `/del_file/${apartment_id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                swal.fire("تنبيه","تم حذف الملف بنجاح","info");
                $('.background').hide();
                $(`.${obj}`).parent().remove();
            }
        });
    }
    function btn_cancel(){
        $("#edit .edit").removeClass("animate__backInUp").html("");
        $("#edit").addClass("animate__fadeOut");
    }
    function change_renter(contract_id, name){
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        $.ajax({
            url: `/all_renter`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $('.background').hide();
                let str=`<div class="row">
                            <p class="h3 text-center w-100 mt-5">تغيير مستأجر ${name}</p>
                            <div class="col-8 mt-3 ml-auto mr-auto">
                                <label for="h_start_date" class="float-right">
                                    ${name}
                                </label>
                            </div>
                            <div class="col-8 ml-auto mr-auto mt-3 mb-5 cus-input">
                                <label for="renter" class="float-right">
                                    * اختر المستأجر
                                </label>
                                <select class="selectpicker w-100" title="اختر المستأجر" id="renter" data-live-search="true" data-actions-box="true"  >`;
                                    jQuery.each( result.renters, function( i, renter ) {
                                        str+=`<option value="${renter.id}">${renter.name}</option>`;
                                    });
                                str+=`</select>
                            </div>
                            <div class="col-6 text-center">
                                <button class="btn btn-success" onclick="btn_save_apartment_renter(${contract_id});">حفظ</button>
                            </div>
                            <div class="col-6 text-center">
                                <button class="btn btn-danger" onclick="btn_apartment_renter_cancel();">إلغاء الأمر</button>
                            </div>
                        </div>`;
                $("#edit").removeClass("d-none animate__fadeOut").show();
                $("#edit .edit").addClass("w-50 animate__backInUp").html(str);
                $(".selectpicker").selectpicker("refresh");
            }
        })
    }
    function btn_apartment_renter_cancel(){
        $("#edit").addClass("d-none animate__fadeOut").hide();
        $("#edit .edit").removeClass("animate__backInUp").html(``);
    }
    function btn_save_apartment_renter(contract_id){
        if($("#renter").val() == ""){
            swal.fire("استكمال البيانات", "الرجاء اختر مستأجر" ,"error");
            return;
        }
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        renter_id=$("#renter").val();
        form_data.append('_token',_token);
        btn_apartment_renter_cancel();
        $.ajax({
            url: `/change_apartment_renter/${contract_id}/${renter_id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                window.location.reload();
            }
        });
    }
}
//renters page
if(page.includes("/renters")){
    $(function(){
        $('#search').on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                $( "#search_btn" ).trigger( "click" );
            }
        })
        $("#search_btn").on("click", function(){
            $('.background').show();
            var _token = $('input[name="_token"]').val().trim();
            var form_data=new FormData();
            form_data.append('_token',_token);
            form_data.append('search',$("#search").val());
            $.ajax({
                url: `/serach_renter`,
                contentType: false,
                enctype: "multipart/form-data",
                processData: false,
                method: "POST",
                data: form_data ,
                success: function (result) {
                    $('.background').hide();
                    $("#renters").html(result);
                }
            });
        });
    });
}
//show renter page
if(page.includes("/renter/")){
    function show_edit(){
        $("#name, #id_number, #phone_number")
            .attr("disabled", false)
            .addClass("edited");
        var str=`<div class="col-6 text-center">
                    <button class="btn btn-success" onclick="btn_save_renter();">حفظ</button>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-danger" onclick="btn_cancel();">إلغاء الأمر</button>
                </div>`;
        $("#controll").html(str);
    }
    function btn_save_renter(){
        if($("#name").val() == "" || $("#id_number").val() == "" || $("#phone_number").val() == ""){
            swal.fire("استكمال البيانات", "الرجاء تسجيل كافة البيانات" ,"info");
            return;
        }
        $('.background').show();
        var _token = $('input[name="_token"]').val().trim();
        var form_data=new FormData();
        form_data.append('_token',_token);
        var current_url = window.location.pathname;
        var id = current_url.split("").pop();
        var name = $("#name").val();
        var id_number = $("#id_number").val();
        var phone_number = $("#phone_number").val();
        form_data.append('name',name);
        form_data.append('id_number',id_number);
        form_data.append('phone_number',phone_number);
        $.ajax({
            url: `/update_renter/${id}`,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                swal.fire(result.title , result.message , result.icon);
                $('.background').hide();
                if(result.success == "true")
                    btn_cancel();
            }
        })
    }
    function btn_cancel(){
        $("#name, #id_number, #phone_number")
            .attr("disabled", true)
            .removeClass("edited");
        $("#controll").html("");
    }
    function show_edit_date(contract_id){
        let str=`<div class="row animate__animated" id="edit">
                    <div class="col background show">
                        <div class="col-6 edit animate__animated">
                        <p class="h3 text-center w-100 pt-5">العقد رقم ${contract_id}</p>
                            <div class="row">
                                <div class="col-10 mt-3 ml-auto mr-auto">
                                    <label for="h_start_date" class="float-right">
                                        تاريخ بداية العقد
                                    </label>
                                </div>
                                <div class="col-10 ml-auto mr-auto cus-input">
                                    <label for="h_start_date" class="float-right">
                                        <i class="far fa-calendar-alt txt-master"></i>
                                    </label>
                                    <input type="text" class="hijri-date-input" placeholder="تاريخ بداية العقد" title="تاريخ بداية العقد" name="h_start_date" id="h_start_date" />
                                </div>
                                <div class="col-10 mt-5 ml-auto mr-auto">
                                    <label for="h_start_date" class="float-right">
                                        تاريخ نهاية العقد
                                    </label>
                                </div>
                                <div class="col-10 ml-auto mr-auto cus-input">
                                    <label for="h_end_date" class="float-right">
                                        <i class="far fa-calendar-alt txt-master"></i>
                                    </label>
                                    <input type="text" class="hijri-date-input" placeholder="تاريخ نهاية العقد" title="تاريخ نهاية العقد" name="h_end_date" id="h_end_date" />
                                </div>
                                <div class="col-6 text-center mt-5">
                                    <button class="btn btn-success" onclick="btn_save_contract_date(${contract_id});">حفظ</button>
                                </div>
                                <div class="col-6 text-center mt-5">
                                    <button class="btn btn-danger" onclick="btn_Date_cancel();">إلغاء الأمر</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        $("body").append(str);
        initHijrDatePicker();
    }
    function btn_Date_cancel(){
        $("#edit").remove();
    }
    function btn_save_contract_date(contract_id){
        if($("#h_start_date").val() == "" || $("#h_end_date").val() == ""){
            swal.fire({
                title: "الرجاء استكمال البيانات",icon:"error",
            });
            return;
        }
        var _token = $('input[name="_token"]').val().trim();
        $(".background").show();
        var form_data=new FormData();
        form_data.append('_token',_token);
        form_data.append('contract_id',contract_id);
        form_data.append('h_start_date',$("#h_start_date").val());
        form_data.append('h_end_date',$("#h_end_date").val());
        btn_Date_cancel();
        $.ajax({
            url: "/upd_contract_date",
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            method: "POST",
            data: form_data ,
            success: function (result) {
                $(".background").hide();
                swal.fire("تم بنجاح", "حفظ البيانات", "error");
            }
        });
    }
}
//general functions

function show_pwd(event){
    event.preventDefault();
    $('.collapse').collapse('hide');
    $('.pwd').show();
}
function redirect_to_reset(){
    var pwd = $('#pwd111').val();
    var _token = $('input[name="_token"]').val().trim();
    var form_data=new FormData();
    form_data.append('_token',_token);
    form_data.append('pwd',pwd);
    $.ajax({
        url: "/check_pwd",
        contentType: false,
        enctype: "multipart/form-data",
        processData: false,
        method: "POST",
        data: form_data ,
        success: function (result) {
            if(result!='false'){
                ///reset/{email}/{confirmation_code}/{reset}
                window.location.replace('/reset/'+result.email+'/'+result.token+'/reset');
            }
            else{
                $('.alert.alert-danger').removeClass('d-none');
            }
        }
    })
}

function is_email(email){
    return (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(email)
    && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(email));
}
function is_number(value){
    return value.replace(/[^\d.]/,'');
}


$(function () {
    if(!page.includes("/login")){
        $('input').attr('autocomplete', 'off')
            .attr('readonly', true)
            .on("focus", function(){
                $(this).attr('readonly', false);
            })
            .on("focusout", function(){
                $(this).attr('readonly', true);
            });
    }
    initHijrDatePicker();

    initHijrDatePickerDefault();

    $('.disable-date').hijriDatePicker({

        minDate:"2020-01-01",
        maxDate:"2021-01-01",
        viewMode:"years",
        hijri:true
    });

});

function initHijrDatePicker() {

    $(".hijri-date-input").hijriDatePicker({
        locale: "ar-sa",
        format: "YYYY-MM-DD",
        hijriFormat:"iYYYY-iMM-iDD",
        dayViewHeaderFormat: "MMMM YYYY",
        hijriDayViewHeaderFormat: "iMMMM iYYYY",
        showSwitcher: false,
        allowInputToggle: false,
        useCurrent: true,
        isRTL: true,
        viewMode:'days',
        keepOpen: false,
        hijri: true,
        showClear: true,
        showTodayButton: true,
        showClose: true,
        // debug:true

    });
}

function initHijrDatePickerDefault() {

    $(".hijri-date-default").hijriDatePicker({
        locale: "ar-sa",
        format: "YYYY-MM-DD",
        hijriFormat:"iYYYY-iMM-iDD",
        dayViewHeaderFormat: "MMMM YYYY",
        hijriDayViewHeaderFormat: "iMMMM iYYYY",
        showSwitcher: true,
        allowInputToggle: true,
        useCurrent: false,
        isRTL: true,
        viewMode:'days',
        keepOpen: false,
        hijri: true,
        showClear: true,
        showTodayButton: true,
        showClose: true,
        // debug:true

    });
}
function make_as_read(id,url){
    event.preventDefault();
    var _token = $('input[name="_token"]').val().trim();
    var form_data=new FormData();
    form_data.append('_token',_token);
    $.ajax({
        url: "/make_as_read/"+id,
        contentType: false,
        enctype: "multipart/form-data",
        processData: false,
        method: "POST",
        data: form_data ,
        success: function () {
            window.location.href=url;
            if(id=='0'){
                window.location.reload();
            }
        }
    })
}
$(function(){
    if($(".container-fluid").length >0 ){
        $(".container").css("maxWidth","100%");
        $(".table-responsive").css("display","unset")
    }
});
// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;

var pusher = new Pusher('4d962d8976817f24b0a0', {
    cluster: 'ap2',
    useTLS : true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    }
});

function show_message(message , url){
    $.notify({
        message: message
    },{
        type: 'minimalist',
        animate: {
            enter: 'animated fadeInLeft',
            exit: 'animated fadeOutLeft'
        },
        placement: {
            from: "bottom",
            align: "left"
        },
        // delay: 100000000
    });
}
//numbers page
function get_number(){
    $('.background').show();
    var _token = $('input[name="_token"]').val().trim();
    var form_data=new FormData();
    form_data.append('_token',_token);
    $.ajax({
        url: "/get_number" ,
        contentType: false,
        enctype: "multipart/form-data",
        processData: false,
        method: "POST",
        data: form_data ,
        success: function (result) {
            if(result=='لا يوجد المزيد من الأرقام'){
                $('.background').hide();
                $('.btn.btn-primary').remove();
                $('.alert.alert-success').removeClass('d-none').html('<span class="color-red">' + result + '</span>')
            }
            else{
                $('.background').hide();
                $('.btn.btn-primary').remove();
                $('.alert.alert-success').removeClass('d-none').html('رقمك هو <span class="color-red">' + result + '</span>')
            }
        }
    });
}
