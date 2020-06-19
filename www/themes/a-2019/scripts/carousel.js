// select car on the home page
var modellink = document.querySelector(".selecting__link");
var modelvalue = document.querySelector(".selecting__link span");
var consumption = document.querySelector(".selecting + div p span");
var selecting = document.querySelector(".selecting__choose--model > ul");
var currentModel = document.querySelector(".selecting__choose--model > span");

function close() {
  selecting.classList.toggle("opened");
  document.removeEventListener("click", close, false);
}

currentModel.addEventListener("click", function(event) {
  event.stopPropagation();
  selecting.classList.toggle("opened");

  setTimeout(function() {
    document.addEventListener("click", close, false);
  }, 200);
});

selecting.addEventListener("click", function(event) {
  if (event.target.tagName === "LI") {
    event.stopPropagation();

    const {dataset: {rate, value, link}, innerText} = event.target

    consumption.innerText = rate;
    modelvalue.innerText = value;
    currentModel.innerText = innerText;
    modellink.href = link;

    selecting.classList.toggle("opened");
    document.removeEventListener("click", close, false);
  }
});

// cars carousel on the home page
function carousel() {

  const animate = (draw, duration) => {
  const start = performance.now();

  requestAnimationFrame(function animate(time) {
    let timePassed = time - start;

    timePassed = timePassed > duration
    ? duration
    : timePassed

    draw(timePassed);

    if (timePassed < duration) {
      requestAnimationFrame(animate)
    }
  });
}

const models = [
  {
    model: 'A1',
    cars: [
      {
        name: 'A1 Sportback',
        source: 'audi-a1-1',
        link: 'audi-a1-sportback',
        rate: '6.0 - 4.6 л'
      },
    ]
  },
  {
    model: 'A3',
    cars: [
      {
        name: 'A3 Sportback',
        source: 'audi-a3-sportback-2019-1',
        link: 'audi-a3-sportback',
        rate: '6.6 - 3.9 л'
      },
      {
        name: 'A3 Sporback g-tron',
        source: 'audi-a3-sportback-g-tron-1',
        link: 'audi-a3-sportback-g-tron',
        rate: '3.5 кДж'
      },
      {
        name: 'A3 Limousine',
        source: 'audi-a3-limousine-2019-1',
        link: 'audi-a3-limousine',
        rate: '6.5 - 3.8 л'
      },
      {
        name: 'A3 Cabriolet',
        source: 'audi-a3-cabriolet-2019-1',
        link: 'audi-a3-cabriolet',
        rate: '6.8 - 5.1 л'
      },
      {
        name: 'S3 Sportback',
        source: 'audi-s3-sportback-2019-1',
        link: 'audi-s3-sportback',
        rate: '7.0 - 6.8 л'
      },
      {
        name: 'S3 Limousine',
        source: 'audi-s3-limousine-2019-1',
        link: 'audi-s3-limousine',
        rate: '6.9 - 6.8 л'
      },
      {
        name: 'S3 Cabriolet',
        source: 'audi-s3-cabriolet-2019-1',
        link: 'audi-s3-cabriolet',
        rate: '7.3 - 7.1 л'
      },
      {
        name: 'RS 3 Sportback',
        source: 'audi-rs3-sportback-1',
        link: 'audi-rs3-sportback',
        rate: '8.5 л'
      },
      {
        name: 'RS 3 Limousine',
        source: 'audi-rs3-limousine-1',
        link: 'audi-rs3-limousine',
        rate: '8.5 л'
      }
    ]
  },
  {
    model: 'A4',
    cars: [
      {
        name: 'A4 Limousine',
        source: 'audi-a4-limousine-2019-1',
        link: 'audi-a4-limousine',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'A4 Avant',
        source: 'audi-a4-avant-2019-1',
        link: 'audi-a4-avant',
        rate: '6.8 - 4.2 л'
      },
      {
        name: 'A4 Avant g-tron',
        source: 'audi-a4-avant-g-tron-2018-1',
        link: 'audi-a4-avant-g-tron',
        rate: '4.1 - 3.9 кДж'
      },
      {
        name: 'A4 allroad quattro',
        source: 'audi-a4-allroad-quattro-1',
        link: 'audi-a4-allroad-quattro',
        rate: '6.8 - 6.6 л'
      },
      {
        name: 'S4 Limousine',
        source: 'audi-s4-limousine-1',
        link: 'audi-a4-limousine',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'S4 Avant',
        source: 'audi-s4-avant-1',
        link: 'audi-s4-avant',
        rate: '7.9 - 7.7 л'
      },
      {
        name: 'RS4 Avant',
        source: 'audi-rs4-avant-1',
        link: 'audi-rs4-avant',
        rate: '9.2 л'
      }
    ]
  },
  {
    model: 'A5',
    cars: [
      {
        name: 'A5 Coupe',
        source: 'audi-a5-coupe-2019-1',
        link: 'audi-a5-coupe',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'A5 Sportback',
        source: 'audi-a5-sportback-2019-1',
        link: 'audi-a5-sportback',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'A5 Sportback g-tron',
        source: 'audi-a5-sportback-g-tron-1',
        link: 'audi-a5-sportback-g-tron',
        rate: '4.1 - 3.8 кДж'
      },
      {
        name: 'A5 Cabriolet',
        source: 'audi-a5-cabriolet-2019-1',
        link: 'audi-a5-cabriolet',
        rate: '7.0 - 4.6 л'
      },
      {
        name: 'S5 Coupe',
        source: 'audi-s5-coupe-1',
        link: 'audi-s5-coupe',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'S5 Sportback',
        source: 'audi-s5-sportback-1',
        link: 'audi-s5-sportback',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'S5 Cabriolet',
        source: 'audi-s5-cabriolet-1',
        link: 'audi-s5-cabriolet',
        rate: '8.0 - 7.9 л'
      },
      {
        name: 'RS 5 Coupe',
        source: 'audi-rs5-coupe-1',
        link: 'audi-rs5-coupe',
        rate: '9.1 - 9.0 л'
      },
      {
        name: 'RS 5 Sportback',
        source: 'audi-rs5-sportback-1',
        link: 'audi-rs5-sportback',
        rate: '9.1 л'
      }
    ]
  },
  {
    model: 'A6',
    cars: [
      {
        name: 'A6 Limousine',
        source: 'audi-a6-limousine-1',
        link: 'audi-a6-limousine',
        rate: '7.2 - 4.0 л'
      },
      {
        name: 'A6 Avant',
        source: 'audi-a6-avant-1',
        link: 'audi-a6-avant',
        rate: '4.1 - 7.4 л'
      },
      {
        name: 'A6 allroad quattro',
        source: 'audi-a6-allroad-quattro-1',
        link: 'audi-a6-allroad-quattro',
        rate: '6.5 - 5.6 л'
      },
      {
        name: 'S6 Limousine',
        source: 'audi-s6-limousine-1',
        link: 'audi-s6-limousine',
        rate: '9.4 - 9.2 л'
      },
      {
        name: 'S6 Avant',
        source: 'audi-s6-avant-1',
        link: 'audi-s6-avant',
        rate: '9.6 - 9.4 л'
      }
    ]
  },
  {
    model: 'A7',
    cars: [
      {
        name: 'A7 Sportback',
        source: 'audi-a7-sportback-1',
        link: 'audi-a7-sportback',
        rate: '7.3 - 4.4 л'
      },
      {
        name: 'S7 Sportback',
        source: 'audi-s7-sportback-1',
        link: 'audi-s7-sportback',
        rate: '6.5 л'
      }
    ]
  },
  {
    model: 'A8',
    cars: [
      {
        name: 'A8',
        source: 'audi-a8-1',
        link: 'audi-a8',
        rate: '7.9 - 5.6 л'
      },
      {
        name: 'A8 L',
        source: 'audi-a8-l-1',
        link: 'audi-a8-l',
        rate: '7.9 - 5.6 л'
      }
    ]
  },
  {
    model: 'Q2',
    cars: [
      {
        name: 'Q2',
        source: 'audi-q2-1',
        link: 'audi-q2',
        rate: '6.7 - 4.4 л'
      },
      {
        name: 'SQ2',
        source: 'audi-sq2-1',
        link: 'audi-sq2',
        rate: '7.2 - 7.0 л'
      }
    ]
  },
  {
    model: 'Q3',
    cars: [
      {
        name: 'Q3',
        source: 'audi-q3-1',
        link: 'audi-q3',
        rate: '7.6 - 4.7 л'
      }
    ]
  },
  {
    model: 'Q5',
    cars: [
      {
        name: 'Q5',
        source: 'audi-q5-2019-1',
        link: 'audi-q5',
        rate: '7.5 - 5.4 л'
      },
      {
        name: 'SQ5 TDI',
        source: 'audi-sq5-tdi-1',
        link: 'audi-sq5',
        rate: '6.8 - 6.6 л'
      }
    ]
  },
  {
    model: 'Q7',
    cars: [
      {
        name: 'Q7',
        source: 'audi-q7-1',
        link: 'audi-q7',
        rate: '7.0 - 6.5 л'
      },
      {
        name: 'SQ7 TDI 2018',
        source: 'audi-sq7-1',
        link: 'audi-sq7-tdi',
        rate: '7.6 - 7.2 л'
      }
    ]
  },
  {
    model: 'Q8',
    cars: [
      {
        name: 'Q8',
        source: 'audi-q8-1',
        link: 'audi-q8',
        rate: '9.1 - 6.4 л'
      }
    ]
  },
  {
    model: 'TT',
    cars: [
      {
        name: 'TT Coupe',
        source: 'audi-tt-coupe-1',
        link: 'audi-tt-coupe',
        rate: '7.0 - 6.0 л'
      },
      {
        name: 'TT Roaster',
        source: 'audi-tt-roadster-1',
        link: 'audi-tt-roadster',
        rate: '7.3 - 6.3 л'
      },
      {
        name: 'TTS Coupe',
        source: 'audi-tts-coupe-1',
        link: 'audi-tts-coupe',
        rate: '7.1 л'
      },
      {
        name: 'TTS Roadster',
        source: 'audi-tts-roadster-1',
        link: 'audi-tts-roadster',
        rate: '7.3 - 7.2 л'
      },
      {
        name: 'TT RS Coupe',
        source: 'audi-tt-rs-coupe-1',
        link: 'audi-tt-rs-coupe',
        rate: '8.0 - 7.9 л'
      },
      {
        name: 'TT RS Roadster',
        source: 'audi-tt-rs-roadster-1',
        link: 'audi-tt-rs-roadster',
        rate: '8.1 - 8.0 л'
      }
    ]
  },
  {
    model: 'R8',
    cars: [
      {
        name: 'R8 Coupe V10 quattro',
        source: 'audi-r8-coupe-v10-1',
        link: 'audi-r8-coupe-v10-quattro',
        rate: '12.9 л'
      },
      {
        name: 'R8 Coupe V10 performance quattro',
        source: 'audi-r8-coupe-v10-performance-1',
        link: 'audi-r8-coupe-v10-performance-quattro',
        rate: '13.1 л'
      },
      {
        name: 'R8 Spyder V10 quattro',
        source: 'audi-r8-spyder-v10-1',
        link: 'audi-r8-spyder-v10-quattro',
        rate: '13.1 - 13.0 л'
      },
      {
        name: 'R8 Spyder V10 performance quattro',
        source: 'audi-r8-spyder-v10-performance-1',
        link: 'audi-r8-spyder-v10-performance-quattro',
        rate: '13.3 л'
      },
      {
        name: 'R8 V10 Decennium',
        source: 'audi-r8-v10-decennium-1',
        link: 'audi-r8-v10-decennium',
        rate: '13.1 л'
      }
    ]
  },
  {
    model: 'e-tron',
    cars: [
      {
        name: 'e-tron',
        source: 'audi-e-tron-1',
        link: 'audi-e-tron',
        rate: '24.6 - 23.7 кДж'
      }
    ]
  }
]

const bodies = [
  {
    body: 'Sportback',
    cars: [
      {
        name: 'A1 Sportback',
        source: 'audi-a1-1',
        link: 'audi-a1-sportback',
        rate: '6.0 - 4.6 л'
      },
      {
        name: 'A3 Sportback',
        source: 'audi-a3-sportback-2019-1',
        link: 'audi-a3-sportback',
        rate: '6.6 - 3.9 л'
      },
      {
        name: 'A3 Sporback g-tron',
        source: 'audi-a3-sportback-g-tron-1',
        link: 'audi-a3-sportback-g-tron',
        rate: '3.5 кДж'
      },
      {
        name: 'S3 Sportback',
        source: 'audi-s3-sportback-2019-1',
        link: 'audi-s3-sportback',
        rate: '7.0 - 6.8 л'
      },
      {
        name: 'RS 3 Sportback',
        source: 'audi-rs3-sportback-1',
        link: 'audi-rs3-sportback',
        rate: '8.5 л'
      },
      {
        name: 'A5 Sportback',
        source: 'audi-a5-sportback-2019-1',
        link: 'audi-a5-sportback',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'A5 Sportback g-tron',
        source: 'audi-a5-sportback-g-tron-1',
        link: 'audi-a5-sportback-g-tron',
        rate: '4.1 - 3.8 кДж'
      },
      {
        name: 'S5 Sportback',
        source: 'audi-s5-sportback-1',
        link: 'audi-s5-sportback',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'RS 5 Sportback',
        source: 'audi-rs5-sportback-1',
        link: 'audi-rs5-sportback',
        rate: '9.1 л'
      },
      {
        name: 'A7 Sportback',
        source: 'audi-a7-sportback-1',
        link: 'audi-a7-sportback',
        rate: '7.3 - 4.4 л'
      },
      {
        name: 'S7 Sportback',
        source: 'audi-s7-sportback-1',
        link: 'audi-s7-sportback',
        rate: '6.5 л'
      }
    ]
  },
  {
    body: 'Limousine',
    cars: [
      {
        name: 'A3 Limousine',
        source: 'audi-a3-limousine-2019-1',
        link: 'audi-a3-limousine',
        rate: '6.5 - 3.8 л'
      },
      {
        name: 'S3 Limousine',
        source: 'audi-s3-limousine-2019-1',
        link: 'audi-s3-limousine',
        rate: '6.9 - 6.8 л'
      },
      {
        name: 'RS 3 Limousine',
        source: 'audi-rs3-limousine-1',
        link: 'audi-rs3-limousine',
        rate: '8.5 л'
      },
      {
        name: 'A4 Limousine',
        source: 'audi-a4-limousine-2019-1',
        link: 'audi-a4-limousine',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'S4 Limousine',
        source: 'audi-s4-limousine-1',
        link: 'audi-a4-limousine',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'A6 Limousine',
        source: 'audi-a6-limousine-1',
        link: 'audi-a6-limousine',
        rate: '7.2 - 4.0 л'
      },
      {
        name: 'S6 Limousine',
        source: 'audi-s6-limousine-1',
        link: 'audi-s6-limousine',
        rate: '9.4 - 9.2 л'
      },
      {
        name: 'A8',
        source: 'audi-a8-1',
        link: 'audi-a8',
        rate: '7.9 - 5.6 л'
      },
      {
        name: 'A8 L',
        source: 'audi-a8-l-1',
        link: 'audi-a8-l',
        rate: '7.7 - 5.6 л'
      }
    ]
  },
  {
    body: 'Cabriolet',
    cars: [
      {
        name: 'A3 Cabriolet',
        source: 'audi-a3-cabriolet-2019-1',
        link: 'audi-a3-cabriolet',
        rate: '6.3 - 4.3 л'
      },
      {
        name: 'S3 Cabriolet',
        source: 'audi-s3-cabriolet-2019-1',
        link: 'audi-s3-cabriolet',
        rate: '6.8 - 6.7 л'
      },
      {
        name: 'A5 Cabriolet',
        source: 'audi-a5-cabriolet-2019-1',
        link: 'audi-a5-cabriolet',
        rate: '6.7 - 4.4 л'
      }
    ]
  },
  {
    body: 'Sportwagen',
    cars: [
      {
        name: 'S3 Sportback',
        source: 'audi-s3-sportback-2019-1',
        link: 'audi-s3-sportback',
        rate: '7.0 - 6.8 л'
      },
      {
        name: 'S3 Limousine',
        source: 'audi-s3-limousine-2019-1',
        link: 'audi-s3-limousine',
        rate: '6.9 - 6.8 л'
      },
      {
        name: 'S3 Cabriolet',
        source: 'audi-s3-cabriolet-2019-1',
        link: 'audi-s3-cabriolet',
        rate: '7.3 - 7.1 л'
      },
      {
        name: 'RS 3 Sportback',
        source: 'audi-rs3-sportback-1',
        link: 'audi-rs3-sportback',
        rate: '8.5 л'
      },
      {
        name: 'RS 3 Limousine',
        source: 'audi-rs3-limousine-1',
        link: 'audi-rs3-limousine',
        rate: '8.5 л'
      },
      {
        name: 'RS 4 Avant',
        source: 'audi-rs4-avant-1',
        link: 'audi-rs4-avant',
        rate: '9.2 л'
      },
      {
        name: 'S5 Coupe',
        source: 'audi-s5-coupe-1',
        link: 'audi-s5-coupe',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'S5 Sportback ',
        source: 'audi-s5-sportback-1',
        link: 'audi-s5-sportback',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'RS 5 Coupe',
        source: 'audi-rs5-coupe-1',
        link: 'audi-rs-5-coupe',
        rate: '9.1 - 9.0 л'
      },
      {
        name: 'RS 5 Sportback',
        source: 'audi-rs5-sportback-1',
        link: 'audi-rs-5-sportback',
        rate: '9.1 л'
      },
      {
        name: 'S6 Limousine',
        source: 'audi-s6-limousine-1',
        link: 'audi-s6-limousine',
        rate: '9.4 - 9.2 л'
      },
      {
        name: 'S6 Avant',
        source: 'audi-s6-avant-1',
        link: 'audi-s6-avant',
        rate: '9.6 - 9.4 л'
      },
      {
        name: 'SQ5 TDI',
        source: 'audi-sq5-tdi-1',
        link: 'audi-sq5',
        rate: '6.8 - 6.6 л'
      },
      {
        name: 'TT Coupe',
        source: 'audi-tt-coupe-1',
        link: 'audi-tt-coupe',
        rate: '5.7 - 9.3 л'
      },
      {
        name: 'TT Roaster',
        source: 'audi-tt-roadster-1',
        link: 'audi-tt-roadster',
        rate: '4.7 - 6.9 л'
      },
      {
        name: 'TTS Coupe',
        source: 'audi-tts-coupe-1',
        link: 'audi-tts-coupe',
        rate: '6.7 - 7.3 л'
      },
      {
        name: 'TTS Roadster',
        source: 'audi-tts-roadster-1',
        link: 'audi-tts-roadster',
        rate: '6.9 - 7.5 л'
      },
      {
        name: 'R8 Coupe V10 quattro',
        source: 'audi-r8-coupe-v10-1',
        link: 'audi-r8-coupe-v10-quattro',
        rate: '12.9 л'
      },
      {
        name: 'R8 Coupe V10 performance quattro',
        source: 'audi-r8-coupe-v10-performance-1',
        link: 'audi-r8-coupe-v10-performance-quattro',
        rate: '13.1 л'
      },
      {
        name: 'R8 Spyder V10 quattro',
        source: 'audi-r8-spyder-v10-1',
        link: 'audi-r8-spyder-v10-quattro',
        rate: '13.1 - 13.0 л'
      },
      {
        name: 'R8 Spyder V10 performance quattro',
        source: 'audi-r8-spyder-v10-performance-1',
        link: 'audi-r8-spyder-v10-performance-quattro',
        rate: '13.3 л'
      },
      {
        name: 'R8 V10 Decennium',
        source: 'audi-r8-v10-decennium-1',
        link: 'audi-r8-v10-decennium',
        rate: '13.1 л'
      }
    ]
  },
  {
    body: 'Avant',
    cars: [
      {
        name: 'A4 Avant',
        source: 'audi-a4-avant-2019-1',
        link: 'audi-a4-avant',
        rate: '6.8 - 4.2 л'
      },
      {
        name: 'A4 Avant g-tron',
        source: 'audi-a4-avant-g-tron-2018-1',
        link: 'audi-a4-avant-g-tron',
        rate: '4.1 - 3.9 кДж'
      },
      {
        name: 'RS 4 Avant',
        source: 'audi-rs4-avant-1',
        link: 'audi-rs4-avant',
        rate: '9.1 л'
      },
      {
        name: 'A6 Avant',
        source: 'audi-a6-avant-1',
        link: 'audi-a6-avant',
        rate: '7.4 - 4.1 л'
      },
      {
        name: 'S6 Avant',
        source: 'audi-s6-avant-1',
        link: 'audi-s6-avant',
        rate: '9.6 - 9.4 л'
      }
    ]
  },
  {
    body: 'allroad quattro',
    cars: [
      {
        name: 'A4 allroad quattro',
        source: 'audi-a4-allroad-quattro-1',
        link: 'audi-a4-allroad-quattro',
        rate: '6.8 - 6.6 л'
      },
      {
        name: 'A6 allroad quattro',
        source: 'audi-a6-allroad-quattro-1',
        link: 'audi-a6-allroad-quattro',
        rate: '6.5 - 5.6 л'
      }
    ]
  },
  {
    body: 'Coupe',
    cars: [
      {
        name: 'A5 Coupe',
        source: 'audi-a5-coupe-2019-1',
        link: 'audi-a5-coupe',
        rate: '6.7 - 4.2 л'
      },
      {
        name: 'S5 Coupe',
        source: 'audi-s5-coupe-1',
        link: 'audi-s5-coupe',
        rate: '7.7 - 7.5 л'
      },
      {
        name: 'RS 5 Coupe',
        source: 'audi-rs5-coupe-1',
        link: 'audi-rs-5-coupe',
        rate: '9.1 - 9.0 л'
      },
      {
        name: 'TT Coupe',
        source: 'audi-tt-coupe-1',
        link: 'audi-tt-coupe',
        rate: '7.0 - 6.0 л'
      },
      {
        name: 'TTS Coupe',
        source: 'audi-tts-coupe-1',
        link: 'audi-tts-coupe',
        rate: '7.1 л'
      },
      {
        name: 'TT RS Coupe',
        source: 'audi-tt-rs-coupe-1',
        link: 'audi-tt-rs-coupe',
        rate: '8.0 - 7.9 л'
      },
      {
        name: 'R8 Coupe V10 quattro',
        source: 'audi-r8-coupe-v10-1',
        link: 'audi-r8-coupe-v10-quattro',
        rate: '12.9 л'
      },
      {
        name: 'R8 Coupe V10 performance quattro',
        source: 'audi-r8-coupe-v10-performance-1',
        link: 'audi-r8-coupe-v10-performance-quattro',
        rate: '13.1 л'
      }
    ]
  },
  {
    body: 'SUV',
    cars: [
      {
        name: 'Q2',
        source: 'audi-q2-1',
        link: 'audi-q2',
        rate: '6.7 - 4.4 л'
      },
      {
        name: 'SQ2',
        source: 'audi-sq2-1',
        link: 'audi-sq2',
        rate: '7.2 - 7.0 л'
      },
      {
        name: 'Q3',
        source: 'audi-q3-1',
        link: 'audi-q3',
        rate: '7.6 - 4.7 л'
      },
      {
        name: 'Q5',
        source: 'audi-q5-2019-1',
        link: 'audi-q5',
        rate: '7.5 - 5.4 л'
      },
      {
        name: 'SQ5 TDI',
        source: 'audi-sq5-tdi-1',
        link: 'audi-sq5',
        rate: '6.8 - 6.6 л'
      },
      {
        name: 'Q7',
        source: 'audi-q7-1',
        link: 'audi-q7',
        rate: '7.0 - 6.5 л'
      },
      {
        name: 'Q8',
        source: 'audi-q8-1',
        link: 'audi-q8',
        rate: '9.1 - 6.4 л'
      },
      {
        name: 'e-tron',
        source: 'audi-e-tron-1',
        link: 'audi-e-tron',
        rate: '24.6 - 23.7 кДж'
      }
    ]
  },
  {
    body: 'Roadster',
    cars: [
      {
        name: 'TT Roaster',
        source: 'audi-tt-roadster-1',
        link: 'audi-tt-roadster',
        rate: '7.3 - 6.3 л'
      },
      {
        name: 'TTS Roadster',
        source: 'audi-tts-roadster-1',
        link: 'audi-tts-roadster',
        rate: '7.3 - 7.2 л'
      },
      {
        name: 'TT RS Roadster',
        source: 'audi-tt-rs-roadster-1',
        link: 'audi-tt-rs-roadster',
        rate: '8.1 - 8.0 л'
      }
    ]
  },
  {
    body: 'Spyder',
    cars: [
      {
        name: 'R8 Spyder V10 quattro',
        source: 'audi-r8-spyder-v10-1',
        link: 'audi-r8-spyder-v10-quattro',
        rate: '13.1 - 13.0 л'
      },
      {
        name: 'R8 Spyder V10 performance quattro',
        source: 'audi-r8-spyder-v10-performance-1',
        link: 'audi-r8-spyder-v10-performance-quattro',
        rate: '13.3 л'
      }
    ]
  }
]

const btnSwitchModel = document.querySelector('.carousel__tabs--model'),
      btnSwitchBody = document.querySelector('.carousel__tabs--body'),

      containerModels = document.querySelector('.carousel__item--models'),
      containerBodies = document.querySelector('.carousel__item--bodies'),

      sliderModelsBtnLeft = document.querySelector('.carousel__item--models button:nth-child(1)'),
      sliderBodiesBtnLeft = document.querySelector('.carousel__item--bodies button:nth-child(2)'),
      sliderModelsBtnRight = document.querySelector('.carousel__item--models button:nth-child(2)'),
      sliderBodiesBtnRight = document.querySelector('.carousel__item--bodies button:nth-child(2)'),

      modelsWrapper = document.querySelector('.carousel__item--models .carousel__wrapper'),
      bodiesWrapper = document.querySelector('.carousel__item--bodies .carousel__wrapper'),

      sliderModels = document.querySelector('.carousel__item--models .slider'),
      sliderBodies = document.querySelector('.carousel__item--bodies .slider')

  // TOGGLE CLASSES
  const classToggler = (arr) => {
      arr.forEach(element => element.classList.toggle('active'))
  }

  // SLIDE
  const slideLeft = (cars) => {
      const target = cars ? modelsWrapper : bodiesWrapper,
          currentScroll = target.scrollLeft,
          wrapperWidth = parseInt(getComputedStyle(target).width),
          animationTime = 300

      currentScroll !== 0 &&
      animate((timePassed) => {
          target.scrollLeft = currentScroll - timePassed / (animationTime / wrapperWidth)
      }, animationTime)
  }
  const slideRight = (cars) => {
      const target = cars ? modelsWrapper : bodiesWrapper,
          slider = cars ? sliderModels : sliderBodies,
          currentScroll = target.scrollLeft,
          wrapperWidth = parseInt(getComputedStyle(target).width),
          animationTime = 300

          console.log(currentScroll, wrapperWidth)

      currentScroll !== parseInt(getComputedStyle(slider).width) - wrapperWidth &&
      animate((timePassed) => {
          target.scrollLeft = currentScroll + timePassed / (animationTime / wrapperWidth)
      }, animationTime)
  }

  // DELETE CONTENT
  const deleteContent = (content, wrapper, target) => {
      wrapper.style.height = 0
      wrapper.removeChild(content)
      target && target.classList.toggle('active')
  }

  // CREATE CONTENT
  const createContent = (target, wrapper, cars) => {
    const currentModel = cars
      ? target.dataset.model
      : target.dataset.body,
    currentCars = cars
      ? models.filter(carModel => carModel.model === currentModel)[0].cars
      : bodies.filter(carBody => carBody.body === currentModel)[0].cars,
    contentNode = document.createElement('div'),
    template = `<div class="btn secondary circle active">
                  <span></span>
                  <span></span>
                </div>
                <p class="content__name">${currentModel}</p>
                <div class="content__models">
                  ${currentCars.map(car =>
                    `<a href="/modelnyy-ryad/${car.link}">
                      <img src='https://img.audi-kiev.com.ua/data/catalog/${car.source}.png'>
                      <span>${car.name}</span>
                      ${car.rate
                        ? `<div>
                              <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.5,15.4 C18.6,19.2 15.7,22.3 11.9,22.5 C11.8,22.5 11.6,22.5 11.5,22.5 C7.6,22.4 4.5,19.3 4.5,15.4 C4.5,11.5 11.5,1.5 11.5,1.5 C11.5,1.5 18.5,11.6 18.5,15.4 Z" stroke="#000" stroke-width="1" fill="none" fill-rule="evenodd"/>
                              </svg>
                              <span>${car.rate} / 100 км</span>
                            </div>`
                        : null
                      }
                    </a>`
                  )}
                </div>`

      contentNode.classList.add('content')

      if (cars) {
          contentNode.dataset.model = currentModel
      } else {
          contentNode.dataset.body = currentModel
      }

      contentNode.innerHTML = template
      wrapper.appendChild(contentNode)

      const closeBtn = document.querySelector('.carousel .btn'),
          content = document.querySelector('.carousel .carousel__content .content')

      wrapper.style.height = `${content.clientHeight}px`

      closeBtn.addEventListener('click', () => {
          deleteContent(content, wrapper, target)
      })
  }

  // SHOW CONTENT
  const showContent = (event, cars) => {
      const target = event.target.classList.contains('slide')
      ? event.target
      : event.target.parentElement

      if (target.classList.contains('slide')) {
          const content = document.querySelector(`.carousel__item--${cars ? 'models' : 'bodies'} .content`),
              wrapper = document.querySelector(`.carousel__item--${cars ? 'models' : 'bodies'} .carousel__content`),
              activeSlide = document.querySelector('.carousel .slide.active'),
              notOurContent = cars
                              ? content && (content.dataset.model !== target.dataset.model)
                              : content && (content.dataset.body !== target.dataset.body)

          if (content) {
              deleteContent(content, wrapper, target)
              notOurContent && createContent(target, wrapper, cars)
          } else {
              createContent(target, wrapper, cars)
          }

          activeSlide && activeSlide.classList.remove('active')
          target !== activeSlide && target.classList.add('active')
      }
  }

  // SWITCH TAB
  btnSwitchModel.addEventListener('click', () => {
      const content = document.querySelector('.carousel__item--bodies .content'),
          activeSlide = document.querySelector('.carousel .slide.active'),
          wrapper = document.querySelector('.carousel__item--bodies .carousel__content')

      activeSlide && activeSlide.classList.toggle('active')
      bodiesWrapper.scrollLeft = 0
      content && deleteContent(content, wrapper)
      classToggler([btnSwitchModel, btnSwitchBody, containerModels, containerBodies])
  })
  btnSwitchBody.addEventListener('click', () => {
      const content = document.querySelector('.carousel__item--models .content'),
          activeSlide = document.querySelector('.carousel .slide.active'),
          wrapper = document.querySelector('.carousel__item--models .carousel__content')

      activeSlide && activeSlide.classList.toggle('active')
      modelsWrapper.scrollLeft = 0
      content && deleteContent(content, wrapper)
      classToggler([btnSwitchModel, btnSwitchBody, containerModels, containerBodies])
  })

  // NEXT/PREV SLIDE CARS
  sliderModelsBtnLeft.addEventListener('click', () => {
      slideLeft(true)
  })
  sliderModelsBtnRight.addEventListener('click', () => {
      slideRight(true)
  })

  // NEXT/PREV SLIDE Body
  sliderBodiesBtnLeft.addEventListener('click', () => {
  slideLeft(false)
  })
  sliderBodiesBtnRight.addEventListener('click', () => {
      slideRight(false)
  })

  // CLICK ON SLIDE
  sliderModels.addEventListener('click', event => {
      showContent(event, true)
  })
  sliderBodies.addEventListener('click', event => {
      showContent(event, false)
  })
}

carousel()