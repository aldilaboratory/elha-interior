<!DOCTYPE html>
<html>
<head>
    <title>Test CSRF and Fetch</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Test CSRF and Fetch Endpoint</h1>
    
    <div id="status"></div>
    
    <button onclick="getCsrfToken()">1. Get CSRF Token</button>
    <button onclick="testLogin()">2. Test Login</button>
    <button onclick="testFetchTransaksi()">3. Test Fetch Transaksi</button>
    <button onclick="testFetchProduk()">4. Test Fetch Produk</button>
    
    <div id="results"></div>

    <script>
        let csrfToken = '{{ csrf_token() }}';
        
        function updateStatus(message) {
            document.getElementById('status').innerHTML = '<p>' + message + '</p>';
        }
        
        function updateResults(data) {
            document.getElementById('results').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        }

        function getCsrfToken() {
            updateStatus('Using Laravel CSRF token: ' + csrfToken);
            
            // Set up AJAX with token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        }

        function testLogin() {
            updateStatus('Testing login...');
            
            $.ajax({
                url: '/authenticate',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    email: 'admin@gmail.com',
                    password: 'password'
                },
                success: function(response) {
                    updateStatus('Login successful!');
                    updateResults(response);
                },
                error: function(xhr) {
                    updateStatus('Login failed: ' + xhr.status + ' ' + xhr.statusText);
                    updateResults(xhr.responseText);
                }
            });
        }

        function testFetchTransaksi() {
            updateStatus('Testing fetch transaksi...');
            
            $.ajax({
                url: '/admin/transaksi/fetch',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    _token: csrfToken,
                    draw: 1,
                    start: 0,
                    length: 10
                },
                success: function(response) {
                    updateStatus('Fetch transaksi successful!');
                    updateResults(response);
                },
                error: function(xhr) {
                    updateStatus('Fetch transaksi failed: ' + xhr.status + ' ' + xhr.statusText);
                    updateResults(xhr.responseText);
                }
            });
        }

        function testFetchProduk() {
            updateStatus('Testing fetch produk...');
            
            $.ajax({
                url: '/admin/produk/fetch',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    _token: csrfToken,
                    draw: 1,
                    start: 0,
                    length: 10
                },
                success: function(response) {
                    updateStatus('Fetch produk successful!');
                    updateResults(response);
                },
                error: function(xhr) {
                    updateStatus('Fetch produk failed: ' + xhr.status + ' ' + xhr.statusText);
                    updateResults(xhr.responseText);
                }
            });
        }

        // Auto-setup CSRF token on page load
        $(document).ready(function() {
            getCsrfToken();
        });
    </script>
</body>
</html>