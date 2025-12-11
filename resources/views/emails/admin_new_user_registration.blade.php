<!DOCTYPE html>
<html>

<head>
       <title>New User Registration</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
       <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
              <h2 style="color: #0056b3;">New User Registration Alert</h2>
              <p>Hello Admin,</p>
              <p>A new user has just registered on XpertBid.</p>

              <h3>User Details:</h3>
              <table style="width: 100%; border-collapse: collapse;">
                     <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold; width: 30%;">
                                   Name:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $user->name }}</td>
                     </tr>
                     <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Email:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $user->email }}</td>
                     </tr>
                     <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Registration
                                   Method:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                                   {{ ucfirst($user->provider ?? 'Email') }}
                            </td>
                     </tr>
                     <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;">Date:</td>
                            <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                                   {{ $user->created_at->format('d M Y, h:i A') }}
                            </td>
                     </tr>
              </table>

       </div>
</body>

</html>