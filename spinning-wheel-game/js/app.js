document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');
    const spinBtn = document.getElementById('spinBtn');
    const modal = document.getElementById('modal');
    const closeModal = document.querySelector('.close-modal');
    const claimBtn = document.getElementById('claimBtn');
    
    let prizes = [];
    let currentRotation = 0;
    let isSpinning = false;
    
    // Load configuration
    fetch('data/prizes.json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('gameTitle').textContent = data.title;
            document.getElementById('gameSubtitle').textContent = data.subtitle;
            prizes = data.prizes;
            drawWheel();
        })
        .catch(err => console.error('Error loading config:', err));
        
    function drawWheel() {
        if (!prizes.length) return;
        
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = canvas.width / 2 - 10;
        const sliceAngle = (2 * Math.PI) / prizes.length;
        
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        prizes.forEach((prize, index) => {
            const startAngle = index * sliceAngle;
            const endAngle = startAngle + sliceAngle;
            
            // Draw slice
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, startAngle, endAngle);
            ctx.closePath();
            ctx.fillStyle = prize.color;
            ctx.fill();
            ctx.stroke();
            
            // Draw text
            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(startAngle + sliceAngle / 2);
            ctx.textAlign = "right";
            ctx.fillStyle = prize.textColor;
            ctx.font = "bold 16px Arial";
            ctx.fillText(prize.label, radius - 20, 5);
            ctx.restore();
        });
    }
    
    function spinWheel() {
        if (isSpinning) return;
        
        // Filter available prizes (quantity > 0)
        const availablePrizes = prizes.filter(p => p.quantity > 0);
        
        if (availablePrizes.length === 0) {
            alert(t('noPrizes'));
            return;
        }
        
        isSpinning = true;
        spinBtn.disabled = true;
        
        // Winning logic based on probability
        const rand = Math.random();
        let cumulativeProbability = 0;
        let selectedPrize = availablePrizes[availablePrizes.length - 1]; // Default fallback
        
        for (const prize of availablePrizes) {
            cumulativeProbability += prize.probability;
            if (rand <= cumulativeProbability) {
                selectedPrize = prize;
                break;
            }
        }
        
        // Find index of selected prize in original array
        const prizeIndex = prizes.findIndex(p => p.id === selectedPrize.id);
        
        // Calculate rotation
        // Extra spins (5-10 full rotations) + arc to target
        const extraSpins = 5 + Math.random() * 5;
        const sliceAngle = (2 * Math.PI) / prizes.length;
        
        // Target angle logic: 
        // 0 degrees is at 3 o'clock. Pointer is at 12 o'clock (-PI/2)
        // We need to rotate so the target slice is at 12 o'clock
        const targetAngleInWheel = prizeIndex * sliceAngle + sliceAngle / 2;
        const rotateTo = extraSpins * 2 * Math.PI + (3 * Math.PI / 2) - targetAngleInWheel;
        
        // Animation
        const duration = 5000; // 5 seconds
        const startTime = performance.now();
        
        function animate(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Ease out cubic
            const ease = 1 - Math.pow(1 - progress, 3);
            
            currentRotation = rotateTo * ease;
            
            ctx.save();
            ctx.translate(canvas.width/2, canvas.height/2);
            ctx.rotate(currentRotation);
            ctx.translate(-canvas.width/2, -canvas.height/2);
            drawWheel();
            ctx.restore();
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                isSpinning = false;
                spinBtn.disabled = false;
                showResult(selectedPrize);
            }
        }
        
        requestAnimationFrame(animate);
    }
    
    function showResult(prize) {
        // Decrease quantity
        prize.quantity--;
        
        // Show modal
        document.getElementById('modalTitle').textContent = t('congrats');
        document.getElementById('modalMessage').textContent = `${t('wonMessage')} ${prize.label}!`;
        modal.classList.remove('hidden');
        
        // Play effect
        if (prize.effect === 'confetti' && window.confetti) {
            window.confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 }
            });
        }
    }
    
    spinBtn.addEventListener('click', spinWheel);
    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    claimBtn.addEventListener('click', () => modal.classList.add('hidden'));
    
    // Close modal on outside click
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    });
});
