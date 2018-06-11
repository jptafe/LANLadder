document.addEventListener('DOMContentLoaded', function() {
    var options = {"accordion": false}
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, options);
});

function color(value){
    console.log(value);
}