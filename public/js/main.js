
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})


$(document).ready(function(){
 });

var BaseRecord={
top9: 1,
search: '',

more: function(){

var ajaxSetting={
method: 'get',
url: './',
data: {
top9: this.top9,
search: this.search,
},
success: function(data){
$('.row.products_row').html(data.table);
},

};
$.ajax(ajaxSetting);
},

remove_S: function(id){

var ajaxSetting={
method: 'post',
url: './clear_S',
data: {
id: id,

},
success: function(data){
//alert(data);

BaseRecord.cart();

},

};
$.ajax(ajaxSetting);
},

cart: function(){

var ajaxSetting={
method: 'get',
url: './cart',

success: function(data){
//alert(data);
$('.cart_items_list').html(data.table);

 $('.listbuttonremove').click(function(){

          BaseRecord.remove_S($(this).attr('id'));
            return false;

          });


},

};
$.ajax(ajaxSetting);
},


mailer: function(message, contact){

	//if(message!=''&& contact!=''){

var ajaxSetting={
method: 'post',
url: './mailer',
data: {
message: message,
contact: contact,

},
success: function(data){
//alert(data.answer);
if(data.answer){
var data_json=JSON.parse(data.answer);
if(data_json['mail']&&data_json['request'])
{
$('.result_to_email').html('Your message has been successfully sent...');
$('.result_to_email').css('color', 'green');
}
else
{
$('.result_to_email').html('Error');
$('.result_to_email').css('color', 'red');
}

}else{
	var data_json=JSON.parse(data);

	var error_str='';
	for(var i in data_json){

		error_str+=data_json[i]+'\n';
	}

	alert(error_str);
}



},

};
$.ajax(ajaxSetting);

//}
//else
//{
//alert('Fields must be filled')
//}

},

clearAll: function(){

var ajaxSetting={
method: 'post',
url: './clearAll',
//data: {
//id: id,

//},
success: function(data){
//alert(data);

BaseRecord.cart();

},

};
$.ajax(ajaxSetting);
},



};