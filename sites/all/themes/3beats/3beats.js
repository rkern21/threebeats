function facebook_connect_dialog(){
    FB.Connect.requireSession(_update_user_box);
}

function _update_user_box(){
    //your code here. like change button state... etc..
    FB.XFBML.Host.parseDomTree();
}
