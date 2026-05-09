<?php
// FILE: packing_list.php
require_once 'auth_check.php';

$page_title = "Packing List Architect";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-suitcase-rolling" style="color:var(--primary); margin-right:15px;"></i> Packing List Architect</h1>
    <p>Generate a tailored packing list based on your destination and climate.</p>
</div>

<div class="grid grid-3 mb-4">
    <div class="glass-card stat-card animate-gravity delay-1" onclick="generateList('UK')" style="cursor:pointer;">
        <i class="fa-solid fa-cloud-showers-heavy" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>UK / Europe</h3>
        <p style="font-size:12px; color:var(--text-muted);">Rain-proof & Layering</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2" onclick="generateList('Canada')" style="cursor:pointer;">
        <i class="fa-solid fa-snowflake" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>Canada / USA</h3>
        <p style="font-size:12px; color:var(--text-muted);">Arctic-grade Gear</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-3" onclick="generateList('Australia')" style="cursor:pointer;">
        <i class="fa-solid fa-sun" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>Australia / Asia</h3>
        <p style="font-size:12px; color:var(--text-muted);">Light & Breathable</p>
    </div>
</div>

<div id="list-container" style="display:none;">
    <div class="glass-card animate-gravity">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <h2 id="destination-title">UK Packing Essentials</h2>
            <button class="btn-primary" onclick="window.print()" style="padding:10px 20px; font-size:12px;">
                <i class="fa-solid fa-print"></i> Print List
            </button>
        </div>
        
        <div class="grid grid-2" id="packing-items">
            <!-- Items injected by JS -->
        </div>
    </div>
</div>

<style>
.pack-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(255,255,255,0.02);
    border: 1px solid var(--border-glass);
    border-radius: 12px;
    margin-bottom: 10px;
}
.pack-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
}
</style>

<script>
const lists = {
    UK: [
        "High-quality Waterproof Jacket",
        "Multiple Warm Sweaters / Hoodies",
        "Universal Travel Adapter (Type G)",
        "Sturdy Umbrella (Wind-proof)",
        "Noise-cancelling Headphones for flight",
        "Portable Power Bank",
        "Basic First-Aid Kit",
        "Important Document Folder (Physical)"
    ],
    Canada: [
        "Heavy Down Parka (-20°C rated)",
        "Thermal Underwear (Uniqlo Heattech)",
        "Waterproof Snow Boots",
        "Woolen Socks & Gloves",
        "Touch-screen compatible mittens",
        "Universal Adapter (Type A/B)",
        "Extra Lip Balm & Moisturizer",
        "Laptop with Good Battery Life"
    ],
    Australia: [
        "Lightweight Linen/Cotton Clothing",
        "Strong Sunscreen (SPF 50+)",
        "Comfortable Walking Shoes",
        "Swimwear (Beach Ready)",
        "UV-rated Sunglasses",
        "Universal Adapter (Type I)",
        "Reusable Water Bottle",
        "Digital copies of all documents"
    ]
};

function generateList(dest) {
    const container = document.getElementById('list-container');
    const title = document.getElementById('destination-title');
    const itemsArea = document.getElementById('packing-items');
    
    container.style.display = 'block';
    title.innerText = `${dest} Packing Essentials`;
    
    let html = '';
    lists[dest].forEach(item => {
        html += `
            <div class="pack-item">
                <input type="checkbox">
                <span>${item}</span>
            </div>
        `;
    });
    itemsArea.innerHTML = html;
    container.scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php include 'footer.php'; ?>
