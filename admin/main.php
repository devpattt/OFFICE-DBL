
<?php 
include '../includes/isset.php';
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/darkmode.css">
    <link rel="icon" href="../public/img/DBL.png">
    <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
    <title>DBL ISTS</title>
  </head>
<body>
  <nav id="sidebar">
    <ul>
      <li>
        <span class="logo">DBL ISTS</span>
        <button onclick=toggleSidebar() id="toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </button>
      </li>
      <li>
        <a href="home.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="active">
        <a href="main.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-280h160v-160H280v160Zm240 0h160v-160H520v160ZM280-520h160v-160H280v160Zm240 0h160v-160H520v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
          <span>Attendance</span>
        </a>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h207q16 0 30.5 6t25.5 17l57 57h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Zm400-160v40q0 17 11.5 28.5T600-320q17 0 28.5-11.5T640-360v-40h40q17 0 28.5-11.5T720-440q0-17-11.5-28.5T680-480h-40v-40q0-17-11.5-28.5T600-560q-17 0-28.5 11.5T560-520v40h-40q-17 0-28.5 11.5T480-440q0 17 11.5 28.5T520-400h40Z"/></svg>
          <span>Dropdown</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Dropdown 1</a></li>
            <li><a href="#">Dropdown 2</a></li> 
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m221-313 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-228q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm0-320 142-142q12-12 28-11.5t28 12.5q11 12 11 28t-11 28L250-548q-12 12-28 12t-28-12l-86-86q-11-11-11-28t11-28q11-11 28-11t28 11l57 57Zm339 353q-17 0-28.5-11.5T520-320q0-17 11.5-28.5T560-360h280q17 0 28.5 11.5T880-320q0 17-11.5 28.5T840-280H560Zm0-320q-17 0-28.5-11.5T520-640q0-17 11.5-28.5T560-680h280q17 0 28.5 11.5T880-640q0 17-11.5 28.5T840-600H560Z"/></svg>
          <span>Dropdown</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="#">Dropdown 1</a></li>
            <li><a href="#">Dropdown 2</a></li> 
          </div>
        </ul>
      </li>
      <li>
        <a href="calendar.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Calendar</span>
        </a>
      </li>
      <li>
        <a href="profile.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>Profile</span>
        </a>
      </li>
      <li>
        <button id="theme-switch" class="darkmode-btn">
          <span class="icon sun">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/></svg>
              <path fill="currentColor" d="M12 4.5A1.5 1.5 0 1 1 12 1.5a1.5 1.5 0 0 1 0 3Zm0 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm7.5-9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM6 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm12.02-5.52a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12ZM6.1 17.9a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12Zm0-11.8A1.5 1.5 0 1 1 3.98 3.98 1.5 1.5 0 0 1 6.1 6.1Zm11.8 11.8a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z" />
            </svg>
          </span>
          <span class="icon moon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/></svg>
              <path fill="currentColor" d="M21 12.79A9 9 0 0 1 11.21 3a7 7 0 1 0 9.79 9.79Z"/>
            </svg>
          </span>
          <span class="label">Dark Mode</span>
        </button>
      </li>  
    </ul>
  </nav>
  <main>
    <div class="container">
      <h2>Hello World</h2>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis porro iure quaerat aliquam! Optio dolorum in eum provident, facilis error repellendus excepturi enim dolor deleniti adipisci consectetur doloremque, unde maiores odit sapiente. Atque ab necessitatibus laboriosam consequatur eius similique, ex dolorum eum eaque sequi id veritatis voluptates perspiciatis, cupiditate pariatur.</p>
    </div>
    <div class="container">
      <h2>Example Heading</h2>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic aliquid corrupti, tenetur fuga magnam necessitatibus blanditiis quod sint excepturi laborum esse alias labore molestias adipisci, nostrum corporis ex maiores quis dolore quidem asperiores odio ad fugit eos! Delectus modi quas ipsa deleniti consequuntur nihil, hic in ipsum exercitationem blanditiis natus, ex, expedita eos. Excepturi quidem harum hic nam magnam deserunt illum quis dolorum eos ipsum ut natus sapiente sit, officia obcaecati assumenda tempore molestias? In fugiat iure laboriosam quasi, eum suscipit, harum autem saepe ut, soluta aspernatur ducimus eos magnam quidem officiis. Laboriosam nemo explicabo delectus, et quos vero cum?</p>
    </div>
    <div class="container">
      <h2>Lorem Ipsum</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore repudiandae labore veniam reprehenderit voluptatum, laboriosam perferendis fuga, dolore quam quas nostrum totam sunt esse expedita. Vero distinctio omnis accusantium. Quisquam ullam saepe cupiditate magni numquam totam perspiciatis error velit, debitis veniam labore possimus aut sunt, reiciendis natus. Impedit provident voluptatum nulla fuga error a magnam, corporis natus aperiam fugit quod perferendis quos quaerat, numquam sequi doloribus tenetur dolorem voluptate deleniti, odio minus. Deserunt eius quasi odit voluptas unde voluptatum dicta cumque exercitationem soluta beatae porro distinctio, delectus officiis, nobis officia ullam necessitatibus, rem natus corrupti nam! Est, nihil molestias fugiat sed quae enim commodi expedita soluta tempore molestiae fuga adipisci rem esse voluptates quos, ut quasi sunt ad a perspiciatis ducimus maxime animi. Adipisci officia doloribus magni alias maiores ab quo, eos mollitia sint esse. Labore odio, architecto nihil quaerat soluta blanditiis impedit laudantium esse officiis dolorum dolore libero, id sequi minima incidunt eum facilis itaque distinctio. Voluptas doloremque minus reiciendis ex beatae laudantium cum sequi repellat blanditiis molestiae. Cumque, libero nulla! Sit, quisquam magni dolore consectetur odio impedit adipisci voluptas ab, laboriosam autem nihil nam est ipsa excepturi obcaecati eos neque! Omnis similique qui veritatis. Repellat magni dolorem, facilis eaque, harum molestias, delectus est adipisci laudantium velit optio blanditiis debitis? Tenetur totam maiores animi officiis eligendi expedita nemo corrupti distinctio. Cum libero soluta beatae doloribus sit, repellendus nobis vel obcaecati velit dolorem voluptate magnam inventore quas pariatur quam reprehenderit molestiae hic sunt dicta illo amet quis magni accusamus sequi? Vel quis, dolores iusto suscipit excepturi laboriosam repellat consectetur! Maiores deserunt, pariatur nesciunt consequuntur recusandae minima assumenda consequatur inventore natus debitis illo velit voluptatum necessitatibus qui aspernatur illum impedit magni dignissimos ea, molestias tempora corporis, asperiores iusto possimus. Libero expedita aspernatur officia totam dolorum culpa, minus, alias adipisci eligendi suscipit voluptates, magnam laudantium? Inventore cupiditate perspiciatis mollitia excepturi, voluptatibus ducimus expedita provident. Dicta, odit. Odio, qui repudiandae! Maiores dignissimos, magnam deleniti reprehenderit ex cum ea eveniet placeat quae, ad at perspiciatis nobis corporis doloribus voluptatem nulla aliquam sunt accusamus facere quaerat necessitatibus ipsa! Nam quisquam dicta minima commodi nostrum. Exercitationem necessitatibus optio cumque voluptate modi amet consequuntur similique ex inventore explicabo doloremque esse sed sequi nemo rem, nostrum ullam. Totam repellat ut ipsa quisquam rem, nulla, suscipit debitis atque earum quis voluptates quaerat exercitationem architecto repellendus placeat, tenetur incidunt distinctio consectetur reiciendis minima officiis aliquam? Ipsum sequi hic officia iste a. Blanditiis, dicta! Eveniet molestias ut natus odio fugiat cum necessitatibus, architecto, quo a quisquam autem porro explicabo ipsam, nostrum deserunt possimus expedita eum est corporis quibusdam cupiditate! Fugiat, quaerat saepe. Harum modi eligendi beatae alias fugiat. Nostrum cum nisi saepe dicta iste cupiditate, deserunt omnis, doloremque a distinctio eum rem adipisci ab? Sapiente, dicta ipsam blanditiis earum omnis necessitatibus temporibus, excepturi accusantium delectus quo quod iusto ad aliquam nemo ducimus ab nobis inventore sequi veritatis? Nulla, dolorem. Voluptas, obcaecati non facilis repellendus ratione officiis veritatis, modi culpa rerum placeat voluptatum quia ex? Officia quos dolorum repellat deserunt voluptas praesentium.</p>
    </div>
  </main>
  
      
    <div id="logout-warning" style="display:none; position:fixed; bottom:30px; right:30px; background:#fff8db; color:#8a6d3b; border:1px solid #f0c36d; padding:15px 20px; z-index:1000; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
          <strong>Inactive for too long.</strong><br>
          Logging out in <span id="countdown">10</span> seconds...
      </div>

      <div id="session-expired-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:2000; justify-content:center; align-items:center;">
          <div style="background:#fff; padding:30px; border-radius:12px; text-align:center; max-width:400px; margin:auto; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
              <h2 style="margin-bottom:10px;">Session Expired</h2>
              <p style="margin-bottom:20px;">You've been inactive for too long. Please log in again.</p>
              <button id="logout-confirm-btn" style="padding:10px 20px; background-color:#ef4444; color:white; border:none; border-radius:8px; cursor:pointer;">Okay</button>
          </div>
      </div>
      
    <script src="../public/js/session.js"></script>
<script src="../public/js/main.js"></script>
</body>
</html>