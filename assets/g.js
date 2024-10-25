let window_current_width = 200;
console.log('GSAP script running');  // Debugging check

// Make the stamp bounce down then rotate
gsap.from(".stamp", {duration: 4, y: 30, x: window_current_width, ease: "sine"});
gsap.to(".stamp", {rotation: 360, duration: 2, ease: "bounce.out"});
