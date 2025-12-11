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