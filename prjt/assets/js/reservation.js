document.addEventListener('DOMContentLoaded', function() {
    // Données des véhicules
    const vehicles = [
        {
            id: 1,
            name: 'Renault Clio',
            category: 'compact',
            image: 'img/clio.png',
            pricePerDay: 35
        },
        {
            id: 2,
            name: 'VOLKSWAGEN TOUAREG',
            category: 'berline',
            image: 'img/VOL.png',
            pricePerDay: 70
        },
        {
            id: 3,
            name: 'BMW Série 3',
            category: 'luxe',
            image: 'img/bmw.png',
            pricePerDay: 100
        },
        {
            id: 4,
            name: 'Dacia Duster',
            category: 'suv',
            image: 'img/duster.png',
            pricePerDay: 55
        },
        {
            id: 5,
            name: 'Peugeot 308',
            category: 'berline',
            image: 'img/peugeot.png',
            pricePerDay: 50
        },
        {
            id: 6,
            name: 'Mercedes Classe C',
            category: 'luxe',
            image: 'img/mercedes.png',
            pricePerDay: 120
        }
    ];

    // Éléments du DOM
    const vehicleSelection = document.getElementById('vehicleSelection');
    const startDateInput = document.getElementById('startDate');
    const durationSelect = document.getElementById('rentalDuration');
    const selectedVehiclePriceElement = document.getElementById('selectedVehiclePrice');
    const rentalDurationDisplayElement = document.getElementById('rentalDurationDisplay');
    const totalPriceElement = document.getElementById('totalPrice');
    const reservationForm = document.getElementById('reservationForm');

    // Variables pour le calcul du prix
    let selectedVehicleId = null;
    let selectedDuration = 0;

    // Définir la date minimale à aujourd'hui
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    startDateInput.min = formattedDate;
    startDateInput.value = formattedDate;

    // Vérifier si un véhicule est passé par URL
    const urlParams = new URLSearchParams(window.location.search);
    const vehicleIdFromUrl = urlParams.get('vehicleId');

    // Afficher les véhicules
    function displayVehicles() {
        vehicleSelection.innerHTML = vehicles.map(vehicle => {
            const isSelected = vehicle.id.toString() === vehicleIdFromUrl;
            if (isSelected) {
                selectedVehicleId = vehicle.id;
                updatePriceSummary();
            }
            
            return `
                <div class="col-md-4">
                    <div class="card vehicle-selection-card ${isSelected ? 'selected' : ''}" data-id="${vehicle.id}" data-price="${vehicle.pricePerDay}">
                        <img src="${vehicle.image}" class="card-img-top" alt="${vehicle.name}">
                        <div class="card-body text-center">
                            <h5 class="card-title">${vehicle.name}</h5>
                            <p class="card-text">${vehicle.pricePerDay}€/jour</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Ajouter des événements de clic
        document.querySelectorAll('.vehicle-selection-card').forEach(card => {
            card.addEventListener('click', function() {
                // Enlever la sélection précédente
                document.querySelectorAll('.vehicle-selection-card').forEach(c => c.classList.remove('selected'));
                
                // Ajouter la sélection actuelle
                this.classList.add('selected');
                
                // Mettre à jour le véhicule sélectionné
                selectedVehicleId = parseInt(this.dataset.id);
                
                // Mettre à jour le récapitulatif de prix
                updatePriceSummary();
            });
        });
    }

    // Gérer le changement de durée
    durationSelect.addEventListener('change', function() {
        selectedDuration = parseInt(this.value) || 0;
        updatePriceSummary();
    });

    // Mettre à jour le récapitulatif de prix
    function updatePriceSummary() {
        if (selectedVehicleId && selectedDuration) {
            const selectedVehicle = vehicles.find(vehicle => vehicle.id === selectedVehicleId);
            
            if (selectedVehicle) {
                selectedVehiclePriceElement.textContent = `${selectedVehicle.name} (${selectedVehicle.pricePerDay}€/jour)`;
                rentalDurationDisplayElement.textContent = `${selectedDuration} jour(s)`;
                
                const total = selectedVehicle.pricePerDay * selectedDuration;
                totalPriceElement.textContent = total;
            }
        } else {
            selectedVehiclePriceElement.textContent = '-';
            rentalDurationDisplayElement.textContent = '-';
            totalPriceElement.textContent = '-';
        }
    }

    // Traiter le formulaire de réservation
    reservationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!selectedVehicleId) {
            alert('Veuillez sélectionner un véhicule.');
            return;
        }
        
        if (!selectedDuration) {
            alert('Veuillez sélectionner une durée de location.');
            return;
        }
        
        const pickupLocation = document.getElementById('pickupLocation').value;
        const startDate = document.getElementById('startDate').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        
        if (!pickupLocation || !startDate || !email || !phone) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }
        
        // Simuler une réservation réussie
        const selectedVehicle = vehicles.find(vehicle => vehicle.id === selectedVehicleId);
        const totalPrice = selectedVehicle.pricePerDay * selectedDuration;
        
        alert(`Réservation confirmée !\n\n` +
              `Véhicule: ${selectedVehicle.name}\n` +
              `Lieu de retrait: ${pickupLocation}\n` +
              `Date de début: ${startDate}\n` +
              `Durée: ${selectedDuration} jour(s)\n` +
              `Prix total: ${totalPrice}€\n\n` +
              `Un email de confirmation a été envoyé à ${email}.`);
              
        // Rediriger vers la page d'accueil après quelques secondes
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 1000);
    });

    // Initialiser la page
    displayVehicles();
});