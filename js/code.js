document.addEventListener('DOMContentLoaded', function() {
    let options = {"accordion": false}
    let elems = document.querySelectorAll('.collapsible');
    let instances = M.Collapsible.init(elems, options);
    options = {};
    elems = document.querySelectorAll('.materialboxed');
    instances = M.Materialbox.init(elems, options);
});

function color(value){
    console.log(value);
}