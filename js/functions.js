var messageCount = 0;
function message(type, title, content) {
    // type = success/info/warning/danger
    
    
    document.getElementById("message").insertAdjacentHTML('beforeend', '<div id="messagebox' + messageCount + '" class="alert alert-' + type + ' alert-dismissable fade in message"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>' + title + '</strong> ' + content + '</div>');
    var messageBoxName = "messagebox" + messageCount;
    setTimeout(function () {
        document.getElementById(messageBoxName).style.opacity = "1"
    }, 100); // vloeiend binnenkomen en zichtbaar maken        
    messageCount++;
}
