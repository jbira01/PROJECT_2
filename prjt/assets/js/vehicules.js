document.addEventListener('DOMContentLoaded', function() {
    const vehicleGrid = document.getElementById('vehicleGrid');
    const filterButtons = document.querySelectorAll('.filter-btn');

    // Function to create vehicle card HTML
    function createVehicleCard(vehicle) {
        return `
            <div class="col-md-4 mb-4 vehicle-card" data-category="${vehicle.category}">
                <div class="card vehicle-preview-card text-center h-100">
                    <img src="${vehicle.image}" class="card-img-top" alt="${vehicle.name}">
                    <div class="card-body">
                        <h3 class="card-title">${vehicle.name}</h3>
                        <p class="card-text">
                            ${vehicle.features.map(feature => `<span class="badge bg-secondary me-1">${feature}</span>`).join('')}
                        </p>
                        <p class="price">${vehicle.pricePerDay}€/jour</p>
                        <a href="reservation.php?vehicleId=${vehicle.id}" class="btn btn-dark">Réserver</a>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to filter and display vehicles
    function filterVehicles(category = 'all') {
        const allCards = document.querySelectorAll('.vehicle-card');
        
        allCards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Filter button event listeners
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter vehicles
            filterVehicles(this.dataset.category);
            
            // Optional: Add animation
            animateFilteredCards();
        });
    });

    // Optional animation function
    function animateFilteredCards() {
        const visibleCards = document.querySelectorAll('.vehicle-card[style="display: block;"], .vehicle-card:not([style])');
        
        visibleCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    }

    // Initialize animation on page load
    animateFilteredCards();
});