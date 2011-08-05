 function cross(){

/*new Ajax.Request('http://api.3beats.com', {
  method: 'get',
  onSuccess: function(transport) {
    var notice = $('result');
    //var result = transport.responseText;
  //  $("result").innerHTML = result;
 if (transport.responseText.match(/href="http:\/\/prototypejs.org/))
   notice.update('Yes you in top10!!').setStyle({ background: '#dfd' });
   else
    notice.update('No you not in top 10...').setStyle({ background: '#fdd' });
  }
});


*/



new Ajax.Request('http://3beats.com', {
method: 'GET',
crossSite: true,
onLoading: function() {
$("get_contact").style.display="none";
        $("get_contact_loader").style.display="inline";
//things to do at the start
},
onSuccess: function(transport) {
//alert(transport.status);

 var result = transport.responseText||"no response text";

        $("result").innerHTML = result;
//things to do when everything goes well
},
onFailure: function(transport) {
//things to do when we encounter a failure
alert('Failure!');
}
});








 /*  var url ='http://www.yandex.ru';
    new Ajax.Request( url,
      {
          method: 'get',
          crossSite: true,
          onLoading:function(){
       $("get_contact").style.display="none";
        $("get_contact_loader").style.display="inline";
        },
          onLoaded:function(){
            $("get_contact").style.display="inline";
             $("get_contact_loader").style.display="none";
         },
         onSuccess: function(transport){
        alert(transport.status);
        var result = transport.responseText||"no response text";

        $("result").innerHTML = result;
         }
       }
      );
*/

 //new Ajax.Request('http://yandex.ru', { method: 'GET' } );








 }