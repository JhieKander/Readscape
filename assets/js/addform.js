document.getElementById('addImage').addEventListener('click', function() {
    var inputGroup = document.createElement('div');
    inputGroup.classList.add('input-group');
    var input = document.createElement('input');
    input.type = 'file';
    input.name = 'images[]';
    input.placeholder = 'Enter Name';
    input.required = true;
    input.classList.add('form-control');
    input.classList.add('input-fill');
    input.classList.add('mt-2')
    var cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.classList.add('btn');
    cancelButton.classList.add('removeInput');
        var img = document.createElement('img');
    img.src = '../assets/images/icon/close.png';
    img.width = '20';
    cancelButton.appendChild(img);

    cancelButton.addEventListener('click', function() {
        inputGroup.remove(); // Remove the input group when cancel is clicked
    });
    inputGroup.appendChild(input);
    inputGroup.appendChild(cancelButton);
    document.getElementById('inputs').appendChild(inputGroup);
});

// Event delegation to handle dynamically added cancel buttons
document.getElementById('inputs').addEventListener('click', function(event) {
    if (event.target.classList.contains('removeInput')) {
        event.target.parentElement.remove(); // Remove the input group when cancel is clicked
    }
});
