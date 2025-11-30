<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>PamSuCoLo | Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Add custom focus styles */
        .custom-focus:focus {
            border-color: #f89458; /* pamsucolo-primary */
            box-shadow: 0 0 0 3px rgba(248, 148, 88, 0.5); /* pamsucolo-primary with transparency */
        }
        /* Hide sections and make tab switching work */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-pamsucolo-bg text-pamsucolo-text font-sans antialiased" x-data="{ currentTab: 'products' }">

    <div class="min-h-screen flex flex-col">
        
        <header class="sticky top-0 z-40 bg-white shadow-lg border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <div class="flex items-center space-x-2">
                        <img class="w-8 h-8" src="{{ asset('images/logo.png') }}" alt="PamSuCoLo Logo">
                        <span class="text-xl font-bold text-pamsucolo-primary">Admin Panel</span>
                    </div>
                    
                    <nav class="flex space-x-4">
                        <button @click="currentTab = 'products'" 
                                :class="{'text-pamsucolo-primary border-pamsucolo-primary': currentTab === 'products', 'text-gray-500 hover:text-pamsucolo-primary border-transparent': currentTab !== 'products'}"
                                class="px-3 py-2 text-sm font-medium border-b-2 transition duration-150">
                            Products
                        </button>
                        <button @click="currentTab = 'loans'"
                                :class="{'text-pamsucolo-primary border-pamsucolo-primary': currentTab === 'loans', 'text-gray-500 hover:text-pamsucolo-primary border-transparent': currentTab !== 'loans'}"
                                class="px-3 py-2 text-sm font-medium border-b-2 transition duration-150">
                            Loans
                        </button>
                        <button @click="currentTab = 'account'"
                                :class="{'text-pamsucolo-primary border-pamsucolo-primary': currentTab === 'account', 'text-gray-500 hover:text-pamsucolo-primary border-transparent': currentTab !== 'account'}"
                                class="px-3 py-2 text-sm font-medium border-b-2 transition duration-150">
                            My Account
                        </button>
                    </nav>

                </div>
            </div>
        </header>

        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 w-full">

            <section x-show="currentTab === 'products'" x-cloak>
                <h2 class="text-3xl font-bold text-pamsucolo-text mb-8 border-b pb-3">📦 Product Management</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-2xl border border-gray-100 h-fit">
                        <h3 class="text-xl font-bold mb-4" x-text="productId ? 'Edit Product' : 'Add New Product'">Add New Product</h3>
                        
                        <form x-data="{ productId: null }" @submit.prevent="productId ? updateProduct() : addProduct()" class="space-y-4">
                            
                            <div>
                                <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                                <input type="url" id="image_url" required placeholder="https://..."
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                            </div>

                            <div>
                                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" id="product_name" required placeholder="Lanyard - Blue"
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="product_type" class="block text-sm font-medium text-gray-700">Product Type</label>
                                    <select id="product_type" required
                                        class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                                        <option value="Lanyard">Lanyard</option>
                                        <option value="Department Shirt">Department Shirt</option>
                                        <option value="Uniform">Uniform</option>
                                        <option value="Accessories">Accessories</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="size" class="block text-sm font-medium text-gray-700">Size</label>
                                    <select id="size" required
                                        class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="N/A">N/A (e.g., Lanyard)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                                <textarea id="short_description" required rows="2" placeholder="Official university lanyard for student ID."
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base"></textarea>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (₱)</label>
                                <input type="number" id="price" required min="1" step="0.01" placeholder="10.00"
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                            </div>

                            <button type="submit" 
                                    class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pamsucolo-primary transition">
                                <span x-text="productId ? 'Save Changes' : 'Add Product'">Add Product</span>
                            </button>
                            
                            <button x-show="productId" @click="resetForm()" type="button" class="w-full text-sm text-gray-500 hover:text-pamsucolo-primary mt-2">
                                Cancel Edit / Add New
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-bold mb-4">Current Products</h3>
                        <div id="product-list" class="space-y-4">
                            
                            <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-4 border border-gray-100">
                                <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="https://via.placeholder.com/64x64.png?text=L" alt="Product Image" class="rounded-lg">
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="text-lg font-semibold truncate">Basic ID Lace</p>
                                    <p class="text-sm text-gray-500">Lanyard | Size: N/A</p>
                                    <p class="font-bold text-pamsucolo-primary">₱5.00</p>
                                </div>
                                <div class="flex-shrink-0 flex space-x-2">
                                    <button onclick="editProduct(1)" class="p-2 text-blue-600 hover:text-blue-800 transition rounded-md bg-blue-50">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </button>
                                    <button onclick="deleteProduct(1)" class="p-2 text-red-600 hover:text-red-800 transition rounded-md bg-red-50">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-4 border border-gray-100">
                                <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="https://via.placeholder.com/64x64.png?text=S" alt="Product Image" class="rounded-lg">
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="text-lg font-semibold truncate">BSIT Department Shirt</p>
                                    <p class="text-sm text-gray-500">Department Shirt | Size: M</p>
                                    <p class="font-bold text-pamsucolo-primary">₱15.00</p>
                                </div>
                                <div class="flex-shrink-0 flex space-x-2">
                                    <button onclick="editProduct(2)" class="p-2 text-blue-600 hover:text-blue-800 transition rounded-md bg-blue-50">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </button>
                                    <button onclick="deleteProduct(2)" class="p-2 text-red-600 hover:text-red-800 transition rounded-md bg-red-50">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                            
                            </div>
                    </div>
                </div>
            </section>
            
            <hr class="my-12 border-gray-200" x-show="currentTab === 'products'" x-cloak>

            <section x-show="currentTab === 'loans'" x-cloak>
                <h2 class="text-3xl font-bold text-pamsucolo-text mb-8 border-b pb-3">💰 Loan Management</h2>
                
                <div id="loan-list" class="space-y-6">
                    
                    <div class="bg-white p-5 rounded-xl shadow-xl border border-gray-100">
                        <div class="flex justify-between items-start mb-3 border-b pb-3">
                            <div>
                                <p class="text-2xl font-extrabold text-pamsucolo-primary">₱1,500.00</p>
                                <p class="text-sm text-gray-500">Requested for: **BSIT Uniform** & **Textbook**</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                            <div><span class="font-medium text-gray-500">Full Name:</span> **Juan Dela Cruz**</div>
                            <div><span class="font-medium text-gray-500">Campus:</span> Apalit</div>
                            <div><span class="font-medium text-gray-500">Course:</span> BSIT</div>
                            <div><span class="font-medium text-gray-500">Year/Section:</span> 4th / A</div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2 font-medium">Reason for Loan:</p>
                            <p class="text-sm italic text-gray-600">"I need the uniform urgently for our presentation and the book for my final subject. I will pay in two installments."</p>
                        </div>
                        
                        <div class="mt-5 flex space-x-3">
                            <button onclick="approveLoan(3)" class="flex-1 py-2 px-4 rounded-lg text-white font-semibold bg-green-500 hover:bg-green-600 transition">
                                Approve
                            </button>
                            <button onclick="declineLoan(3)" class="flex-1 py-2 px-4 rounded-lg text-white font-semibold bg-red-500 hover:bg-red-600 transition">
                                Decline
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-xl border border-gray-100 opacity-70">
                        <div class="flex justify-between items-start mb-3 border-b pb-3">
                            <div>
                                <p class="text-2xl font-extrabold text-gray-500">₱500.00</p>
                                <p class="text-sm text-gray-500">Requested for: **Tote Bag**</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                            <div><span class="font-medium text-gray-500">Full Name:</span> **Maria Santos**</div>
                            <div><span class="font-medium text-gray-500">Campus:</span> San Fernando</div>
                            <div><span class="font-medium text-gray-500">Course:</span> BS Accountancy</div>
                            <div><span class="font-medium text-gray-500">Year/Section:</span> 2nd / C</div>
                        </div>

                        <div class="mt-5 flex space-x-3">
                            <button disabled class="flex-1 py-2 px-4 rounded-lg text-white font-semibold bg-green-300 cursor-not-allowed">
                                Approved
                            </button>
                            <button disabled class="flex-1 py-2 px-4 rounded-lg text-white font-semibold bg-red-300 cursor-not-allowed">
                                Decline
                            </button>
                        </div>
                    </div>
                    
                    </div>
            </section>

            <section x-show="currentTab === 'account'" x-cloak>
                <h2 class="text-3xl font-bold text-pamsucolo-text mb-8 border-b pb-3">👤 My Admin Account</h2>

                <div class="bg-white p-6 rounded-xl shadow-2xl border border-gray-100 max-w-lg mx-auto">
                    <h3 class="text-xl font-bold mb-4">Admin Profile Information</h3>
                    
                    <form @submit.prevent="updateAdminInfo()" class="space-y-4">
                        
                        <div>
                            <label for="admin_name" class="block text-sm font-medium text-gray-700">Admin Name</label>
                            <input type="text" id="admin_name" value="Admin Name Example" required
                                class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                        </div>
                        
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700">Admin Email</label>
                            <input type="email" id="admin_email" value="admin@pamsucolo.edu" required
                                class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                        </div>

                        <button type="submit" 
                                class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pamsucolo-primary transition">
                            Save Profile Changes
                        </button>
                    </form>
                    
                    <h3 class="text-xl font-bold mt-8 mb-4 pt-4 border-t">Update Password</h3>
                    
                    <form @submit.prevent="updateAdminPassword()" class="space-y-4">
                        
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" id="current_password" required
                                class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" id="new_password" required
                                class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                        </div>
                        
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" required
                                class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                        </div>
                        
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                            Update Password
                        </button>
                    </form>

                    <div class="mt-8 pt-4 border-t">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-lg text-base font-semibold text-pamsucolo-text bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                Log Out
                            </button>
                        </form>
                    </div>

                </div>
            </section>

        </main>
        
        <footer class="bg-gray-100 text-gray-600 py-4 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
                &copy; 2025 PamSuCoLo Admin Panel.
            </div>
        </footer>
    </div>
    
    <script>
        function addProduct() {
            // Placeholder: Implement AJAX call to store product (POST /admin/products)
            alert('Adding new product...');
            // In a real app, reset the form and refresh the product list on success.
        }

        function editProduct(id) {
            // Placeholder: Implement AJAX call to fetch product data (GET /admin/products/{id})
            alert('Fetching product ' + id + ' for editing.');
            // In a real app, populate the form inputs and set productId in Alpine data.
            // Example: Alpine.data('yourFormComponent', { productId: id, ... });
        }

        function updateProduct() {
            // Placeholder: Implement AJAX call to update product (PUT/PATCH /admin/products/{id})
            alert('Updating product...');
            // In a real app, reset the form and refresh the product list on success.
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete product ' + id + '?')) {
                // Placeholder: Implement AJAX call to delete product (DELETE /admin/products/{id})
                alert('Product ' + id + ' deleted!');
                // In a real app, refresh the product list.
            }
        }

        function approveLoan(id) {
            if (confirm('Approve Loan Request ' + id + '?')) {
                // Placeholder: Implement AJAX call to approve loan (POST /admin/loans/{id}/approve)
                alert('Loan ' + id + ' Approved!');
                // In a real app, update the card status and remove buttons.
            }
        }

        function declineLoan(id) {
            if (confirm('Decline Loan Request ' + id + '?')) {
                // Placeholder: Implement AJAX call to decline loan (POST /admin/loans/{id}/decline)
                alert('Loan ' + id + ' Declined!');
                // In a real app, update the card status and remove buttons.
            }
        }

        function updateAdminInfo() {
            // Placeholder: Implement AJAX call to update name/email (PUT /admin/profile)
            alert('Admin info updated.');
        }

        function updateAdminPassword() {
            // Placeholder: Implement AJAX call to update password (PUT /admin/password)
            alert('Admin password updated.');
        }
    </script>
</body>
</html>