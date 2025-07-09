@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ===============================
   DASHBOARD LAYOUT & CARDS
================================ */

body {
    font-family: 'Rubik', sans-serif;
    
}

h1, h2, h3, .stat-header, .stat-count {
    font-family: 'Lexend', sans-serif;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px;
}

.stat-card {
    background-color: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    position: relative;
    border: 2px solid transparent;
    box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.08); /* Always-on shadow */
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.stat-header {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 6px;
    color: #475569;
}

.stat-count {
    font-size: 28px;
    font-weight: bold;
    color: #0f172a;
}

.details-link {
    position: relative;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    padding-bottom: 2px;
}

.details-link::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.details-link:hover::after {
    width: 100%;
}

/* Color-specific styles */
.stat-card.green .details-link {
    color: #10b981;
}
.stat-card.green .details-link::after {
    background-color: #10b981;
}
.stat-card.green .details-link:hover {
    color: #059669;
}

.stat-card.red .details-link {
    color: #ef4444;
}
.stat-card.red .details-link::after {
    background-color: #ef4444;
}
.stat-card.red .details-link:hover {
    color: #dc2626;
}

.stat-card.yellow .details-link {
    color: #f59e0b;
}
.stat-card.yellow .details-link::after {
    background-color: #f59e0b;
}
.stat-card.yellow .details-link:hover {
    color: #d97706;
}

.stat-card.blue .details-link {
    color: #3b82f6;
}
.stat-card.blue .details-link::after {
    background-color: #3b82f6;
}
.stat-card.blue .details-link:hover {
    color: #2563eb;
}



.stat-icon {
    font-size: 28px;
    margin-bottom: 8px;
    display: block;
    transition: transform 0.4s ease;
}
.stat-card:hover {
    transform: scale(1.03); /* ✅ Scale on hover */
}


.stat-card:hover .stat-icon {
    transform: rotate(360deg);
}

.stat-card.blue:hover {
    transform: scale(1.03);
    box-shadow: 0 0 12px 2px rgba(59, 130, 246, 0.3);
    border-color: #3b82f6;
}
.stat-card.green:hover {
    transform: scale(1.03);
    box-shadow: 0 0 12px 2px rgba(16, 185, 129, 0.3);
    border-color: #10b981;
}
.stat-card.yellow:hover {
    transform: scale(1.03);
    box-shadow: 0 0 12px 2px rgba(250, 204, 21, 0.3);
    border-color: #facc15;
}
.stat-card.red:hover {
    transform: scale(1.03);
    box-shadow: 0 0 12px 2px rgba(239, 68, 68, 0.3);
    border-color: #ef4444;
}

/* Blue */
.stat-card.blue .stat-icon,
.stat-card.blue .stat-count {
    color: #3b82f6; /* vivid */
}
.stat-card.blue .stat-header {
    color: #1e40af; /* darker shade of blue */
}

/* Green */
.stat-card.green .stat-icon,
.stat-card.green .stat-count {
    color: #10b981;
}
.stat-card.green .stat-header {
    color: #065f46; /* darker shade of green */
}

/* Yellow */
.stat-card.yellow .stat-icon,
.stat-card.yellow .stat-count {
    color: #f59e0b;
}
.stat-card.yellow .stat-header {
    color: #b45309; /* darker shade of yellow */
}

/* Red */
.stat-card.red .stat-icon,
.stat-card.red .stat-count {
    color: #ef4444;
}
.stat-card.red .stat-header {
    color: #b91c1c; /* darker shade of red */
}

/* ===============================
   SALES SECTION
================================ */
.sales-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.sales-form, .sales-log {
    background-color: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.sales-form form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.sales-form input, .sales-form select {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-family: 'Lexend', sans-serif;
}

.sales-log table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
    border-radius: 16px;
}
.sales-log-table-scroll thead th {
  position: sticky;
  top: 0;
  background-color: #e2e8f0; /* must have background */
  z-index: 1;
  padding: 12px;
}

/* Optional styling */
.sales-log-table-scroll tbody td {
  padding: 12px;
  background-color: #f6eded;
}

/* Optional: nice border under the sticky header */
.sales-log-table-scroll thead th {
    border-bottom: 2px solid #cbd5e1;
}
.sales-log th {
    background-color: #e2e8f0;
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #1e293b;
}

.sales-log td {
    background-color: #f6eded;
    padding: 12px;
    color: #0f172a;
    transition: background-color 0.2s ease;
    border-bottom: 1px solid #e2e8f0;
}

.sales-log tbody tr:hover td {
    background-color: #e0f2fe;
}

tr.highlight-row {
    background-color: #bbf7d0;
}

.button-fill {
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Lexend', sans-serif;
    background-color: transparent;
}
.green-button {
    color: #059669;
    border: 2px solid #059669;
    background-color: white;
}
.green-button:hover {
    background-color: #059669;
    color: white;
}

/* ===============================
   SALES TABLE
================================ */
.sales-log-table-scroll {
    max-height: 370px; /* enough to show ~5 rows depending on row height */
    overflow-y: auto;
    border-radius: 16px;
    width: 100%;
     position: relative;
}

/* Optional: scrollbar style */
.sales-log-table-scroll::-webkit-scrollbar {
    width: 6px;
}
.sales-log-table-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
.sales-log-table-scroll table {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
}
/* Action Column */
.action-cell {
    text-align: center;
    position: relative;
}

.dots-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 8px;
    transition: background 0.2s ease;
}

.dots-btn:hover {
    background-color: #f1f5f9;
}

.dropdown-wrapper {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
  z-index: 9999;
  position: absolute;
  top: 30px;
  right: 0;
  background-color: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  min-width: 120px;
}


.dropdown-menu a {
    display: block;
    padding: 10px 16px;
    text-decoration: none;
    color: #0f172a;
    font-weight: 500;
    transition: background 0.2s ease;
}

.dropdown-menu a:hover {
    background-color: #f1f5f9;
}

.dropdown-menu .delete-link {
    color: #ef4444;
}
.table-info {
    background-color: #e0f2fe;
    font-weight: 500;
}

.undo-button {
    background-color: white;
    color: #1e293b;
    border: 1px solid #1e293b;
    padding: 4px 10px;
    font-size: 13px;
    margin-left: 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.undo-button:hover {
    background-color: #1e293b;
    color: white;
}

/* ===============================
   MODALS
================================ */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    overflow-y: auto;
}
.modal-content {
    background: #fff;
    padding: 24px 28px;
    margin: 5% auto;
    width: 90%;
    max-width: 700px;
    border-radius: 16px;
    font-family: 'Lexend', sans-serif;
    position: relative;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    max-height: 80vh;
    overflow-y: auto;
}

.modal-content h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 16px;
    color: #1f2937;
  
}
.modal-columns {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.modal-column {
    flex: 1;
    min-width: 150px;
}

.modal-column h4 {
    background-color: #f1f5f9; /* light gray */
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 12px;
}

.close {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 18px;
    cursor: pointer;
    font-weight: bold;
    color: #475569;
}

.modal-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: space-between;
}

.modal-column {
    flex: 1;
    min-width: 220px;
}

.modal-column h4 {
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #0f172a;
}

.modal-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 300px;
    overflow-y: auto;
}

.modal-column li {
    padding: 6px 0;
    font-size: 14px;
    font-weight: 500;
    border-bottom: 1px solid #f1f5f9;
}
.modal-column li:last-child {
    border-bottom: none;
}
.modal-column li.red { color: #ef4444; font-weight: 600; }
.modal-column li.orange { color: #f59e0b; font-weight: 600; }

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.cancel-button {
    background-color: white;
    color: #0f172a;
    border: 2px solid #cbd5e1;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.cancel-button:hover {
    background-color: #e0f2fe; /* Light blue */
    color: #0c4a6e;
}

.delete-button {
    background-color: white;
    color: #b91c1c;
    border: 2px solid #ef4444;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.delete-button:hover {
    background-color: #ef4444;
    color: white;
}
.custom-log-modal-content {
  border-radius: 1rem;
}

.custom-log-modal-header {
  background-color: #198754; /* Bootstrap success green or your primary */
  border-bottom: none;
}

.custom-log-modal-body {
  background-color: #f8f9fa;
}

.custom-log-modal-content .modal-title {
  font-size: 1.25rem;
}

.custom-log-modal-content .btn-close {
  opacity: 1;
}
    .sale-header {
        display: flex;
        justify-content: space-between;
    }
    .sale-header .left,
    .sale-header .right {
        text-align: left;
    }
    .sale-header .right {
        text-align: right;
    }
/* ===============================
   TOAST MESSAGE
================================ */
.toast-message {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #4ade80;
    color: #1e293b;
    padding: 14px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    font-family: 'Lexend', sans-serif;
    font-weight: 600;
    z-index: 999;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.toast-message.show {
    opacity: 1;
    transform: translateY(0);
}

/* ===============================
   RESPONSIVE TWEAKS
================================ */
@media (max-width: 480px) {
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 12px;
    }

    .sales-section {
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 20px;
    }

    .sales-form input,
    .sales-form select {
        font-size: 14px;
    }

    .button-fill {
        font-size: 14px;
        padding: 10px;
        width: 100%;
    }

    .sales-log th, .sales-log td {
        font-size: 13px;
        padding: 8px;
    }

    .sales-form label {
        font-size: 14px;
    }

    .sales-log h4,
    .sales-form h4 {
        font-size: 16px;
    }

    .modal-grid {
        flex-direction: column;
    }
}
@media (max-width: 768px) {
    .sales-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

}
.sales-grid {
    display: flex;
    gap: 24px;
}

.sales-grid .log-sale {
    width: 30%;
}

.sales-grid .sales-log {
    width: 70%;
}

@media (max-width: 768px) {
    .sales-grid {
        flex-direction: column;
    }

    .sales-grid .log-sale,
    .sales-grid .sales-log {
        width: 100% !important;
    }
}
/* === LOG SALE MODAL STYLING === */
#logSaleModal .custom-log-modal-content {
  border-radius: 1rem;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  border: none;
  background-color: #ffffff;
  padding: 0;
  overflow: hidden;
}

#logSaleModal .custom-log-modal-header {
  background: linear-gradient(to right, #198754, #28a745);
  padding: 1rem 1.5rem;
  border-bottom: none;
  color: #fff;
}

#logSaleModal .custom-log-modal-body {
  background-color: #f8f9fa;
  padding: 2rem;
}

#logSaleModal .item-row {
  background: #fff;
  padding: 1rem;
  border-radius: 0.75rem;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.05);
  margin-bottom: 1rem;
}

#logSaleModal .form-label {
  font-weight: 600;
  font-size: 0.9rem;
}

#logSaleModal .form-control,
#logSaleModal .form-select {
  border-radius: 0.5rem;
  font-size: 0.9rem;
}

#logSaleModal .remove-row {
  background: #dc3545;
  color: #fff;
  border: none;
  padding: 0.5rem 0.75rem;
  border-radius: 0.5rem;
  font-size: 1rem;
  margin-top: 0.3rem;
}

#logSaleModal .remove-row:hover {
  background: #bb2d3b;
}

#logSaleModal #addRow {
  border-radius: 0.5rem;
  font-weight: 500;
  padding: 0.5rem 1rem;
}

#logSaleModal .btn-success {
  border-radius: 0.5rem;
  padding: 0.5rem 1.5rem;
  font-weight: 600;
  font-size: 0.95rem;
}

#logSaleModal .text-end {
  margin-top: 1.5rem;
}
    #itemRows .card {
        border-radius: 12px;
    }

    #itemRows .btn-danger {
        border-radius: 50%;
        width: 32px;
        height: 32px;
        padding: 0;
    }

    #itemRows select,
    #itemRows input {
        box-shadow: none !important;
    }
/* Modal width */
@media (min-width: 768px) {
  #logSaleModal .modal-dialog {
    max-width: 720px;
  }
}
</style>

<div class="dashboard-grid">
   <div class="stat-card blue">
        <i class="fa-solid fa-boxes-stacked stat-icon"></i>
        <div class="stat-header">Total Products</div>
        <div class="stat-count">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card green">
        <i class="fa-solid fa-wallet stat-icon"></i>
        <div class="stat-header">Total Profit</div>
        <div class="stat-count" id="total-profit">₱{{ number_format($totalProfit, 2) }}</div>
    </div>

    <div class="stat-card yellow">
        <i class="fa-solid fa-arrow-trend-up stat-icon"></i>
        <div class="stat-header">Total Sold</div>
        <div class="stat-count" id="total-sold">{{ $totalSoldQty }}</div>
        <a href="#" onclick="openSoldModal()" class="details-link">Show Details</a>
    </div>

    <div class="stat-card red">
        <i class="fa-solid fa-triangle-exclamation stat-icon"></i>
        <div class="stat-header">Out of Stock</div>
        <div class="stat-count">{{ $lowStock->count() }}</div>
        <a href="#" onclick="openStockModal()" class="details-link">Show Details</a>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<button onclick="resetAllSales()" class="button-fill delete-button" style="margin: 16px 0;">Reset All Sales</button>

<div class="sales-section">
    <div class="sales-grid">
        <div class="log-sale" style="width: 30%;">
            <div class="sales-form">
                
               <!-- Log Sale Button -->
                <div class="mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#logSaleModal">
                        Log Sale
                    </button>
                </div>

            </div>
        </div>
        <div class="sales-log" style="width: 70%;">
            <h4>Today's Sales Log</h4>

            @if ($todaySales->isEmpty())
                <p>No sales recorded today.</p>
            @else
               <div class="sales-log-table-scroll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $groupedSales = $todaySales->groupBy('sale_id');
                            @endphp

                           @foreach($todaySales->groupBy('sale_id') as $saleId => $items)
                              <tr class="bg-light">
                                    <td colspan="6">
                                        <div class="sale-header">
                                            <div class="left">
                                                <strong>Sale ID:</strong> {{ $saleId }}<br>
                                                <strong>Date:</strong> {{ $items->first()->created_at->format('M d, Y h:i A') }}
                                            </div>
                                            <div class="right">
                                                <strong>Discount:</strong> ₱{{ number_format($items->first()->sale->discount_amount ?? 0, 2) }}<br>
                                                <strong>Total:</strong> ₱{{ number_format($items->first()->sale->total_price, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('h:i A') }}</td>
                                        <td>{{ $item->product->name }} (₱{{ number_format($item->product->selling_price, 2) }})</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>—</td>
                                        <td>₱{{ number_format($item->total_price, 2) }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="chart-section" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h4>Analytics Overview</h4>
        <select id="chartTypeSelect" class="form-select" style="width: 200px;">
            <option value="profit">Monthly Total Profit</option>
            <option value="sold">Monthly Total Sold</option>
        </select>

    </div>
    <canvas id="analyticsChart" height="100"></canvas>
</div>


<div id="toast" class="toast-message" style="display: none;"></div>


<!-- Sold Details Modal -->
<div id="soldModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeSoldModal()">&times;</span>
    <h3>Products Sold Today</h3>
    <div class="modal-grid">
      <div class="modal-column">
        <h4>Medicines</h4>
        <ul>
         @forelse($soldDetails->filter(fn($item) => $item->product && $item->product->category === 'medicine') as $item)
            <li>{{ $item->product->name ?? 'Deleted Product' }} – {{ $item->total_quantity }} pcs</li>
        @empty
            <li>No medicines sold.</li>
        @endforelse

        </ul>
      </div>
      <div class="modal-column">
        <h4>Supplies</h4>
        <ul>
       @forelse($soldDetails->filter(fn($item) => $item->product && $item->product->category === 'supplies') as $item)
            <li>{{ $item->product->name ?? 'Deleted Product' }} – {{ $item->total_quantity }} pcs</li>
        @empty
            <li>No supplies sold.</li>
        @endforelse

      </div>
    </div>
  </div>
</div>



<!-- Stock Alert Modal -->
<!-- Stock Alert Modal -->
<div id="stockModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeStockModal()">&times;</span>
    <h3>Low / Out of Stock Products</h3>
    <div class="modal-grid">
      <!-- Very Low Stock Column -->
      <div class="modal-column">
        <h4 class="modal-header red">Very Low Stock</h4>
        <ul>
          @forelse($lowStock->filter(fn($product) => $product->stock < 20) as $product)
            <li class="red">{{ $product->name }} – {{ $product->stock }} left</li>
          @empty
            <li>None</li>
          @endforelse
        </ul>
      </div>

      <!-- Low Stock Column -->
      <div class="modal-column">
        <h4 class="modal-header orange">Low Stock</h4>
        <ul>
          @forelse($lowStock->filter(fn($product) => $product->stock >= 20) as $product)
            <li class="orange">{{ $product->name }} – {{ $product->stock }} left</li>
          @empty
            <li>None</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Edit Sale Modal -->
<div id="editSaleModal" class="modal">
  <div class="modal-content" style="max-width: 400px;">
    <span class="close" onclick="$('#editSaleModal').hide()">&times;</span>
    <h3>Edit Sale</h3>
    <form id="editSaleForm" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf
        <input type="hidden" name="sale_id" id="editSaleId">
        <input type="hidden" name="original_quantity" id="editOriginalQty">

        <div style="display: flex; flex-direction: column; gap: 6px;">
            <label for="editProductName" style="font-weight: 600; color: #1e293b;">Product</label>
            <input type="text" id="editProductName" disabled
                   style="padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1; background-color: #f9fafb;">
        </div>

        <div style="display: flex; flex-direction: column; gap: 6px;">
            <label for="editQuantity" style="font-weight: 600; color: #1e293b;">Quantity</label>
            <input type="number" name="quantity" id="editQuantity" min="1" required
                   style="padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1;">
        </div>

        <div style="display: flex; justify-content: space-between; gap: 10px; margin-top: 10px;">
            <button type="submit" class="button-fill green-button">Update Sale</button>
            <button type="button" class="button-fill delete-button" onclick="openDeleteConfirmModal()">Delete</button>
        </div>

    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal">
  <div class="modal-content" style="max-width: 400px;">
    <span class="close" onclick="$('#deleteConfirmModal').hide()">&times;</span>
    <h3>Confirm Deletion</h3>
    <p>Are you sure you want to delete the sale of <strong id="confirmProductName">this product</strong>?</p>
    <div class="modal-actions" style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
      <button class="button-fill cancel-button" onclick="$('#deleteConfirmModal').hide()">Cancel</button>
      <button class="button-fill delete-button" onclick="confirmDeleteFromModal()">Delete</button>
    </div>
  </div>
</div>
<!-- Log Sale Modal -->
<div class="modal fade" id="logSaleModal" tabindex="-1" aria-labelledby="logSaleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content custom-log-modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header custom-log-modal-header text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="logSaleModalLabel">Log New Sale</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body custom-log-modal-body p-4">
      <form method="POST" action="{{ route('sales.store') }}">
        @csrf
        <div id="items-container">
            <div class="item-group mb-3 border p-3 rounded">
                <div class="form-group mb-2">
                    <label for="product">Product</label>
                    <select name="product_ids[]" class="form-control">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (₱{{ number_format($product->selling_price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity[]" class="form-control" value="1" min="1" required>
                </div>

                <button type="button" class="btn btn-danger remove-item">✖</button>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-secondary mb-3">+ Add Item</button>

        <div class="form-group">
            <label>Discount Type</label>
            <select name="discount_type" class="form-control">
                <option value="PWD">PWD</option>
                <option value="SENIOR">Senior Citizen</option>   
                <option value="NONE">None</option>              

            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Submit Sale</button>
    </form>
      </div>
    </div>
  </div>
</div>


<script>
    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');
        const firstItem = container.querySelector('.item-group');
        const clone = firstItem.cloneNode(true);

        // Clear inputs
        clone.querySelector('select').selectedIndex = 0;
        clone.querySelector('input').value = 1;

        container.appendChild(clone);
    });

    document.getElementById('items-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            const items = document.querySelectorAll('.item-group');
            if (items.length > 1) {
                e.target.closest('.item-group').remove();
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let itemIndex = 1; // Start from 1 if the first item is static

    function addSaleItem() {
        const container = document.getElementById('itemRows');

        const wrapper = document.createElement('div');
        wrapper.className = 'card mb-3 shadow-sm p-4 bg-white rounded border-0 position-relative';
        wrapper.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Product</label>
                    <select class="form-select" name="items[${itemIndex}][product_id]" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} {{ $product->dosage }} (₱{{ number_format($product->selling_price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quantity</label>
                    <input type="number" class="form-control" name="items[${itemIndex}][quantity]" min="1" value="1" required>
                </div>
            </div>
        `;

        container.appendChild(wrapper);
        itemIndex++;
    }
</script>




<script>
document.getElementById('logSaleForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    const productIds = [...form.querySelectorAll('select[name="product_id[]"]')].map(select => select.value);
    const quantities = [...form.querySelectorAll('input[name="quantity[]"]')].map(input => input.value);
    const discountType = form.querySelector('select[name="discount_type"]').value;

    fetch('/sales', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            items: productIds.map((id, i) => ({
                product_id: id,
                quantity: quantities[i]
            })),
            discount_type: discountType
        })
    })
    .then(async res => {
        if (!res.ok) {
            const text = await res.text();
            throw new Error(`Server responded with ${res.status}: ${text}`);
        }
        return res.json();
    })
    .then(response => {
        if (response.success) {
            location.reload(); // 🔁 Reload page on success
        } else {
            alert(response.message);
            submitBtn.disabled = false;
        }
    })
    .catch(err => {
        console.error('Server Error:', err);
        location.reload(); // 🔁 Reload page on error too
    });
});
</script>



<script>

let selectedSaleId = null;

function openEditModal(id, name, productId, quantity) {
    selectedSaleId = id;
    $('#editSaleId').val(id);
    $('#editOriginalQty').val(quantity);
    $('#editProductName').val(name);
    $('#editQuantity').val(quantity);
    $('#confirmProductName').text(name); // <-- insert product name in confirm modal
    $('#editSaleModal').show();
}

function openDeleteConfirmModal() {
    $('#editSaleModal').hide(); // hide edit modal first
    $('#deleteConfirmModal').show(); // show themed confirm modal
}

function confirmDeleteFromModal() {
    if (!selectedSaleId) return;

    $.ajax({
        url: "{{ route('sales.delete') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            sale_id: selectedSaleId
        },
        success: function (res) {
            if (res.success) {
                // Store undo reference
                localStorage.setItem('lastDeletedSaleId', selectedSaleId);
                localStorage.setItem('toastMessage', `
                    ${res.message}
                    <button class="undo-button" onclick="undoDelete(${selectedSaleId})">Undo</button>
                `);
                localStorage.setItem('toastColor', 'red');
                location.reload();
            }
        },
        error: function () {
            alert("Failed to delete sale.");
        }
    });

    $('#deleteConfirmModal').hide();
}





$('#confirmDeleteBtn').on('click', function () {
    $.ajax({
        url: "{{ route('sales.delete') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            sale_id: $('#editSaleId').val()
        },
        success: function (res) {
            if (res.success) {
                localStorage.setItem('toastMessage', res.message);
                localStorage.setItem('toastColor', 'red');
                location.reload(); // refresh to update UI
            }
            $('#deleteConfirmModal').hide();
        },
        error: function () {
            alert("Failed to delete sale.");
        }
    });
});

    function resetAllSales() {
        if (!confirm('Are you sure you want to delete all sales?')) return;

        $.post("{{ route('sales.reset') }}", {
            _token: "{{ csrf_token() }}"
        }).done(function(res) {
            if (res.success) {
                // Visually clear the UI
                $('#total-profit').text('₱0.00');
                $('#total-sold').text('0');
                $('table.table tbody').empty().append(`
                    <tr>
                        <td colspan="6" style="text-align: center;">No sales recorded today.</td>
                    </tr>
                `);
                showToast(res.message, 'red');
            }
        }).fail(() => {
            alert('Failed to reset sales.');
        });
    }
    function undoDelete(saleId) {
        $.ajax({
            url: "{{ route('sales.undo') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                sale_id: saleId
            },
            success: function (res) {
                if (res.success) {
                    localStorage.setItem('toastMessage', res.message);
                    localStorage.setItem('toastColor', 'green');
                    location.reload();
                }
            },
            error: function () {
                alert("Failed to undo the sale.");
            }
        });
    }



    // Modal functions
    function openSoldModal() {
        document.getElementById('soldModal').style.display = 'block';
    }

    function closeSoldModal() {
        document.getElementById('soldModal').style.display = 'none';
    }

    function openStockModal() {
        document.getElementById('stockModal').style.display = 'block';
    }

    function closeStockModal() {
        document.getElementById('stockModal').style.display = 'none';
    }

    window.onclick = function(event) {
        ['soldModal', 'stockModal'].forEach(id => {
            const modal = document.getElementById(id);
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    };

    // AJAX submit handler
    let saleCount = {{ $todaySales->count() }};

    $('#logSaleForm').on('submit', function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        const form = $(this);
        const button = form.find('button');
        button.prop('disabled', true).text('Logging...');

       $.ajax({
            url: "{{ route('sales.store') }}",
            method: "POST",
            data: new FormData(this), // ✅ Support nested arrays
            processData: false,
            contentType: false,
            success: function(response) {
                form[0].reset();
                button.prop('disabled', false).text('Log Sale');

                saleCount++;
                let discountLabel = 'None';
                if (response.discount_type === 'SENIOR') discountLabel = 'Senior Citizen (20%)';
                else if (response.discount_type === 'PWD') discountLabel = 'PWD (20%)';

                response.items.forEach(item => {
                    const newRow = `
                        <tr class="highlight-row">
                            <td>${response.time}</td>
                            <td>${item.product}</td>
                            <td>${item.quantity}</td>
                            <td>${discountLabel}</td>
                            <td>₱${item.subtotal}</td>
                            <td class="action-cell">
                                <button class="dots-btn"
                                    onclick="openEditModal(${item.product_id}, '${item.product}', ${item.product_id}, ${item.quantity})"
                                >⋮</button>
                            </td>
                        </tr>
                    `;
                    $('table.table tbody').prepend(newRow);
                });

                $('.highlight-row').hide().fadeIn(600).removeClass('highlight-row');
                $('#total-profit').text('₱' + response.updatedTotalProfit);
                $('#total-sold').text(response.updatedTotalSold);

                const toast = $('#toast');
                toast.html(response.message).css('display', 'block').addClass('show');
                setTimeout(() => {
                    toast.removeClass('show');
                    setTimeout(() => toast.css('display', 'none'), 400);
                }, 3000);
            },
            error: function(err) {
                button.prop('disabled', false).text('Log Sale');
                alert('Error logging sale. Please check stock or try again.');
            }
        });
});

</script>

<script>
let chart;
const ctx = document.getElementById('analyticsChart').getContext('2d');
function loadChartData(type) {
    fetch(`/chart-data/${type}`)
        .then(res => res.json())
        .then(data => {
            console.log("CHART RESPONSE:", data);
            if (chart) chart.destroy();

            const colors = [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
                '#14b8a6', '#f43f5e', '#eab308', '#0ea5e9', '#6366f1',
                '#ec4899', '#84cc16'
            ];

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: type === 'profit' ? '₱ Total Profit' :
                               type === 'sold' ? 'Units Sold' : 'Most Sold Products',
                        data: data.values,
                        backgroundColor: colors.slice(0, data.labels.length),
                        borderRadius: 10,
                        barPercentage: 0.7,
                        categoryPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    const label = context.label;
                                    if (context.dataset.label.includes('Profit')) {
                                        return `${label}: ₱${value}`;
                                    } else if (context.dataset.label.includes('Units')) {
                                        return `${label}: ${value} pcs`;
                                    } else {
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
}


document.getElementById('chartTypeSelect').addEventListener('change', function () {
    loadChartData(this.value);
});
loadChartData('profit'); // Load default
</script>

<script>
$(document).on('click', '.edit-sale-btn', function () {
    const btn = $(this);
    $('#editSaleId').val(btn.data('sale-id'));
    $('#editOriginalQty').val(btn.data('quantity'));
    $('#editProductName').val(btn.data('product-name'));
    $('#editQuantity').val(btn.data('quantity'));
    $('#editSaleModal').show();
});

// Submit edit sale
$('#editSaleForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        url: "{{ route('sales.update') }}",
        type: "POST",
        data: formData,
        success: function (res) {
            showToast('Sale updated successfully.', 'green'); // ✅ Toast before reload
            setTimeout(() => location.reload(), 1000); // slight delay so toast appears
        },
        error: function () {
            alert("Failed to update sale.");
        }
    });
});

</script>
<script>
function showToast(message, color = 'green') {
    const toast = $('#toast');
    toast.html(message); // ✅ render as HTML

    toast.css({
        display: 'block',
        backgroundColor: color === 'green' ? '#4ade80' : '#f87171',
        color: '#1e293b'
    }).addClass('show');

    setTimeout(() => {
        toast.removeClass('show');
        setTimeout(() => toast.css('display', 'none'), 400);
    }, 3000);
}
</script>

<script>
$(document).ready(function () {
    const msg = localStorage.getItem('toastMessage');
    const color = localStorage.getItem('toastColor');

    if (msg) {
        showToast(msg, color || 'green');
        localStorage.removeItem('toastMessage');
        localStorage.removeItem('toastColor');
    }
});

</script>


@endsection
