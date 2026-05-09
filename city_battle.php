<?php
// FILE: city_battle.php
require_once 'auth_check.php';

$page_title = "City Battle";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-city" style="color:var(--primary); margin-right:15px;"></i> City Battle: Cost of Living</h1>
    <p>Compare the financial reality of different study destinations.</p>
</div>

<div class="glass-card animate-gravity mb-4">
    <div style="display:flex; justify-content:center; align-items:center; gap:20px; flex-wrap:wrap;">
        <select id="city1" style="width:250px; margin:0;" onchange="compareCities()">
            <option value="London" selected>London, UK</option>
            <option value="NewYork">New York, USA</option>
            <option value="Toronto">Toronto, Canada</option>
            <option value="Berlin">Berlin, Germany</option>
        </select>
        <div style="font-size:24px; font-weight:800; color:var(--primary);">VS</div>
        <select id="city2" style="width:250px; margin:0;" onchange="compareCities()">
            <option value="London">London, UK</option>
            <option value="NewYork">New York, USA</option>
            <option value="Toronto" selected>Toronto, Canada</option>
            <option value="Berlin">Berlin, Germany</option>
        </select>
    </div>
</div>

<div class="grid grid-2">
    <!-- City 1 Card -->
    <div class="glass-card animate-gravity delay-1" id="card-city1">
        <h2 id="name-city1">London</h2>
        <div class="cost-item"><span>Average Rent (Studio)</span> <strong id="rent-city1">£1,800</strong></div>
        <div class="cost-item"><span>Monthly Groceries</span> <strong id="food-city1">£350</strong></div>
        <div class="cost-item"><span>Public Transport</span> <strong id="trans-city1">£160</strong></div>
        <div class="cost-item"><span>Total Est. Monthly</span> <strong id="total-city1" style="color:var(--primary);">£2,310</strong></div>
    </div>

    <!-- City 2 Card -->
    <div class="glass-card animate-gravity delay-2" id="card-city2">
        <h2 id="name-city2">Toronto</h2>
        <div class="cost-item"><span>Average Rent (Studio)</span> <strong id="rent-city2">C$2,200</strong></div>
        <div class="cost-item"><span>Monthly Groceries</span> <strong id="food-city2">C$450</strong></div>
        <div class="cost-item"><span>Public Transport</span> <strong id="trans-city2">C$156</strong></div>
        <div class="cost-item"><span>Total Est. Monthly</span> <strong id="total-city2" style="color:var(--primary);">C$2,806</strong></div>
    </div>
</div>

<div class="glass-card mt-4 animate-gravity delay-3 text-center">
    <h3><i class="fa-solid fa-scale-balanced" style="color:var(--accent);"></i> Verdict</h3>
    <p id="verdict-text" style="font-size:18px; font-weight:700; color:var(--text-main);">London is roughly 12% cheaper for students than Toronto when considering total living costs.</p>
</div>

<style>
.cost-item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid var(--border-glass);
}
.cost-item strong { color: #fff; }
</style>

<script>
const cityData = {
    London: { name: "London, UK", rent: "£1,800", food: "£350", trans: "£160", total: 2310, currency: "£" },
    NewYork: { name: "New York, USA", rent: "$2,800", food: "$500", trans: "$127", total: 3427, currency: "$" },
    Toronto: { name: "Toronto, Canada", rent: "C$2,200", food: "C$450", trans: "C$156", total: 2806, currency: "C$" },
    Berlin: { name: "Berlin, Germany", rent: "€1,100", food: "€300", trans: "€90", total: 1490, currency: "€" }
};

function compareCities() {
    const c1 = document.getElementById('city1').value;
    const c2 = document.getElementById('city2').value;
    const d1 = cityData[c1];
    const d2 = cityData[c2];

    document.getElementById('name-city1').innerText = d1.name;
    document.getElementById('rent-city1').innerText = d1.rent;
    document.getElementById('food-city1').innerText = d1.food;
    document.getElementById('trans-city1').innerText = d1.trans;
    document.getElementById('total-city1').innerText = d1.total.toLocaleString() + " " + d1.currency;

    document.getElementById('name-city2').innerText = d2.name;
    document.getElementById('rent-city2').innerText = d2.rent;
    document.getElementById('food-city2').innerText = d2.food;
    document.getElementById('trans-city2').innerText = d2.trans;
    document.getElementById('total-city2').innerText = d2.total.toLocaleString() + " " + d2.currency;

    const diff = Math.round((Math.abs(d1.total - d2.total) / Math.max(d1.total, d2.total)) * 100);
    const cheaper = d1.total < d2.total ? d1.name : d2.name;
    document.getElementById('verdict-text').innerText = `${cheaper} is roughly ${diff}% cheaper for students considering local costs.`;
}

document.addEventListener('DOMContentLoaded', compareCities);
</script>

<?php include 'footer.php'; ?>
