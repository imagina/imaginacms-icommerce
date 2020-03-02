<style type="text/css">
  #body {
    background-color: #e2e2e2;
    padding: 20px 0;
    color: #333333;
    font-family: 'Open Sans', sans-serif;
  }

  .date {
    color: white;
  }

  #template-mail {
    background-color: #ffffff;
    width: 70%;
    margin: auto;
  }

  #contenido {
    padding: 15px;
  }

  a {
      word-break: break-all;
      text-decoration: none;
  }

  header {
      background-color: #841CBB;
      color: #ffffff;
      height: 327px;
      padding: 10px 20px;
  }

  footer {
      background-color:{{Setting::get('site::color-secondary')}};
      color: white;
  }

  footer a {
      text-decoration: none;
  }

  footer i {
      color: #555;
  }

  footer .social {
      margin-bottom: 20px;
  }

  footer .fa-circle-thin {
      color: #555;
  }

  footer .copyright {
      color: #555;
      font-size: 14px;
  }

  /********* form ************/
  .btn-requirement {
    padding: 25px 0;
  }

  .btn-requirement a {
    text-decoration: none;
    background-color: #cc0909;
    padding: 10px;
    margin: 10px 0;
    color: white;
  }

  .seller {
    margin-top: 20px;
  }

  .seller span {
    font-style: italic;
  }

  .seller h3, .seller h4 {
    margin: 2px;
    font-weight: 400;
    text-align: center;
  }

  /******** class **********/
  .float-left {
    float: left !important
  }

  .float-right {
    float: right !important
  }

  .float-none {
    float: none !important
  }

  .text-justify {
    text-align: justify !important
  }

  .text-nowrap {
    white-space: nowrap !important
  }

  .text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
  }

  .text-left {
    text-align: left !important
  }

  .text-right {
    text-align: right !important
  }

  .text-center {
    text-align: center !important
  }

  .text-uppercase {
    text-transform: uppercase;
  }

  .text-capitalize {
    text-transform: capitalize;
  }

  .container {
    width: 85%;
    margin: auto;
  }

  .p-3 {
    padding: 1rem !important
  }

  .px-3 {
    padding: 0 1rem !important
  }

  .py-3 {
    padding: 1rem 0 !important
  }

  .container {
      width: 70%;
      margin: auto;
  }

  hr {
      border:none;
      height: 46px;
      width: 90%;
      box-shadow: 0 20px 20px -20px #333;
      margin: -50px auto 10px;
  }

  table {
      width: 100%;
      border-collapse: collapse;
  }

  .row {
      display: inline-block;
      margin-bottom: 60px;
      text-align: left;
  }

  .col {
      width: 43%;
      display: block;
      float: left;
      padding: 0 15px;
  }

  .row p {
      margin: 0;
  }

  th {
      font-weight: bold;
  }

  th, td {
      text-align: left;
      padding: 8px;
  }

  .title {
      text-align: center;
      width: 80%;
      font-size: 40px;
      margin: 74px auto;
  }

  .header-contend .bg-image {
      border-radius: 50%;
      max-width: 150px;
      height: 150px;
      background: #fff;
      margin: auto;
      padding: 10px;
      overflow: hidden;
      border: #841CBB solid;
      z-index: 10000;
  }

  .header-contend .bg-image img {
      margin-top: 20px;
  }

  .table-products {
      margin-bottom: 15px;
  }

  .table-products thead {
      background-color: #eee;
  }

  .email {
      margin: 120px auto 70px;
      box-shadow: 0px 0px 20px #a99b9b;
  }

  @media only screen and (min-width: 320px) and (max-width: 544.98px) {
      #body {
          font-size: 12px;
      }

      header {
          height: 206px;
      }

      .title {
          font-size: 20px;
          width: 95%;
          margin: 30px auto;
      }

      .btn {
          height: 50px;
          width: 130px;
          font-size: 13px;
      }

      .table-products {
          font-size: 10px;
      }

      .container {
          width: 90%;
      }
  }

  @media only screen and (min-width: 545px) and (max-width: 668px) {
      #body {
          font-size: 14px;
      }

      header {
          height: 219px;
      }

      .title {
          font-size: 28px;
          margin: 30px auto;
      }

      .table-products {
          font-size: 10px;
      }

      .container {
          width: 90%;
      }
  }

  @media only screen and (min-width: 668px) and (max-width: 754.98px) {
      header {
          height: 289px;
      }

      .title {
          font-size: 36px;
          margin: 58px auto;
      }
  }

  @media only screen and (max-width: 992px) {
      #template-mail {
          width: 100%;
      }
  }

  @media only screen and (min-width: 755px) and (max-width: 991.98px){
      header {
          height: 289px;
      }

      .title {
          font-size: 40px;
          margin: 55px auto;
      }
  }

  @media only screen and (min-width: 992px) and (max-width: 1436px) {
      .title {
          font-size: 40px;
          margin: 74px auto;
      }
  }
</style>
