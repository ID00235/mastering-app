$base_url = 'http://eplanning-dev.batangharikab.go.id';
$(function(){
    $(".select2").select2();
});


var showNotify = function($title, $message){
    
    $.notify({
        icon: $base_url + '/img/success.png',
        title: $title,
        message: $message
    },{
        placement: {
            from: "bottom"
        },
        animate:{
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown"
        },
        offset:{
            x:20,
            y:50
        },
        type: 'minimalist',
        delay: 4500,
        icon_type: 'image',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0} alert-dismissible" role="alert">' +
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            '<img data-notify="icon" class="img-circle pull-left">' +
            '<span data-notify="title">{1}</span>' +
            '<span data-notify="message">{2}</span>' +
        '</div>'
    });

}

var showAlert = function($title, $message){

    $.notify({
        icon: $base_url + '/img/warning.png',
        title: $title,
        message: $message
    },{
        placement: {
            from: "bottom"
        },
        animate:{
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown"
        },
        offset:{
            x:20,
            y:50
        },
        type: 'minimalist',
        delay: 4500,
        icon_type: 'image',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0} alert-dismissible" role="alert">' +
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            '<img data-notify="icon" class="img-circle pull-left">' +
            '<span data-notify="title">{1}</span>' +
            '<span data-notify="message">{2}</span>' +
        '</div>'
    });
}

var startLoading = function(){
    $(".loading-panel").html("<i class='fa fa-spinner fa-spin' style='font-size:1.2em; color:#019597;'></i> <span style=' color:#019597;'>Data Sedang Diproses..</span>");
}

var stopLoading = function(){
    $(".loading-panel").html('');
}