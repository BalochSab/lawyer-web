function ShowPreview(input) {
    if (input.files && input.files[0]) {
        var ImageDir = new FileReader();
        ImageDir.onload = function (e) {
            $('#impPrev').attr('src', e.target.result);
        }
        ImageDir.readAsDataURL(input.files[0]);  
    }
}


$('.remove').click(function () {
    $('#impPrev').attr('src', '/imgs/imagesdefault.png');
});