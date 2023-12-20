<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .content {
      flex: 1;
    }

    .footer {
      display: flex;
      justify-content: space-between;
      background-color: #f5ba13;
      text-align: left;
      margin-top: 50px;
      padding-top: 32px;
      padding-left: 64px;
      padding-right: 64px;
      gap: 24px;
    }

    .footer p {
      margin: 5px 0;
      color: #fff;
      font-family: "McLaren", cursive;
      font-weight: 200;
    }

    .footer-svg {
      position: relative;
      bottom: 50px;
      left: 59%;
    }

    @media (min-width: 768px) {
      .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .footer p {
        flex: 1;
      }

      .footer img {
        margin: 0 auto;
      }

      td {
        /* padding-x */
        padding: 0 10px;
      }
    }

    @media (max-width: 768px) {
      .footer-svg {
        display: none;
      }

      .footer {
        flex-direction: column;
      }
    }
  </style>
  <title>Footer Example</title>
</head>

<body>
  <footer class="footer">
    <div class="content">
      <div style="color: white;">
        <table>
          <tr>
            <th>Dibuat oleh:</th>
          </tr>
          <tr>
            <td>Nathaniel Ryo Kurniadi</td>
            <td>5025221019</td>
          </tr>
          <tr>
            <td>Moch Avin</td>
            <td>5025221061</td>
          </tr>
        </table>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="white" class="bi bi-lightbulb-fill footer-svg" viewBox="0 0 16 16">
        <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6m3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5" />
      </svg>
    </div>
    <div>
      <p class="text-end">PWEB C</p>
      <p class="text-end">Imam Kuswardayan, S.Kom, M.T</p>
    </div>

  </footer>
</body>

</html>