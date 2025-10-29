<h2>Welcome to Our Auction!</h2>

<!-- OneSignal SDK script -->
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>

<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function () {
    // Initialize OneSignal
    OneSignal.init({
      appId: "4180f838-909e-4bd1-b604-1e206d9ae4d1", // Replace with your OneSignal App ID
    });

    // Check if OneSignal is initialized
    OneSignal.push(function() {
      OneSignal.getUserId(function(userId) {
        console.log("OneSignal Player ID: ", userId);  // Check if Player ID is printed
      });
    });
  });
</script>
