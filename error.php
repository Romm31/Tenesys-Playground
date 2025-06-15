<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ngapain Kamu Bang?</title>
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 50px;
      overflow: hidden;
      position: relative;
    }

    h1 {
      font-size: 3em;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.5em;
    }

    .emoji {
      font-size: 2em;
    }

    video {
      margin-top: 30px;
      width: 80%;
      max-width: 600px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
      position: relative;
      z-index: 1;
    }

    .emoji-fall {
      position: absolute;
      top: -50px;
      animation: fall linear forwards;
      pointer-events: none;
      z-index: 0;
    }

    @keyframes fall {
      to {
        transform: translateY(110vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

  <h1>Ngapain kamu bang</h1>
  <p>Apakah kamu hengker? <span class="emoji">😲📸</span></p>

  <video autoplay loop muted playsinline controls>
    <source src="/images/yahaha.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <script>
    const emojiList = ["😂", "🤣", "😹", "😂", "🤣", "😹", "😂", "🤣", "😹"];
    const maxEmojis = 1000;
    let currentEmojis = 0;

    function createEmoji() {
      if (currentEmojis >= maxEmojis) return;

      const emoji = document.createElement("div");
      emoji.classList.add("emoji-fall");
      emoji.style.left = Math.random() * 100 + "vw";
      emoji.style.animationDuration = (Math.random() * 3 + 3) + "s";
      emoji.style.fontSize = (Math.random() * 1.5 + 1.5) + "rem";
      emoji.innerText = emojiList[Math.floor(Math.random() * emojiList.length)];

      document.body.appendChild(emoji);
      currentEmojis++;

      // Kurangi jumlah saat emoji dihapus
      setTimeout(() => {
        emoji.remove();
        currentEmojis--;
      }, 7000); // harus lebih panjang dari durasi animasi
    }

    // Loop setiap 100ms tambahkan beberapa emoji jika belum mencapai batas
    setInterval(() => {
      if (currentEmojis < maxEmojis) {
        for (let i = 0; i < 10; i++) {
          createEmoji();
        }
      }
    }, 100);
  </script>

</body>
</html>
