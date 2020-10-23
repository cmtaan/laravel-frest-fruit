let brand = document.getElementById('logo-id');
let images = [];

const readURL = (input) => {
    if (input.files && input.files[0]) {

        images.push(input.files[0]);

        let reader = new FileReader();
        reader.onload = (e) => {
            $('.img-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        console.log(images);
    }
}

const showImage = () => {
    let html = `<img class="thumbnail img-preview" src="%src%">`;
    let newHtml;
    images.forEach((element)=>{
    })
}

$("#logo-id").change(function () {
    readURL(this);
});
