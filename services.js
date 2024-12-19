const services= document.getElementById('services');

 // Loop 10 times to create and append elements
 for (let i = 1; i <= 10; i++) {
    // Create a new div element
    const div = document.createElement('div');
    
    // Add content and class to the div
    div.textContent = services.innerHTML;
    div.className = 'row';

    // Append the div to the container
    services.appendChild(div);
    
}