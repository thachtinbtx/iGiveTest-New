"use client";

import React, { useState } from 'react';

// Reusable Ripple component for the button
const Ripple = ({ duration = 850, color = 'rgba(255, 255, 255, 0.7)' }) => {
  const [rippleArray, setRippleArray] = useState([]);

  const addRipple = (event) => {
    const rippleContainer = event.currentTarget.getBoundingClientRect();
    const size = rippleContainer.width > rippleContainer.height ? rippleContainer.width : rippleContainer.height;
    const x = event.pageX - rippleContainer.x - size / 2;
    const y = event.pageY - rippleContainer.y - size / 2;
    const newRipple = { x, y, size };

    setRippleArray([...rippleArray, newRipple]);
  };

  return (
    <div 
      className="absolute top-0 left-0 right-0 bottom-0 overflow-hidden rounded-full"
      onMouseDown={addRipple}
    >
      {rippleArray.length > 0 &&
        rippleArray.map((ripple, index) => {
          return (
            <span
              key={'ripple_' + index}
              className="absolute bg-white rounded-full animate-ripple"
              style={{ top: ripple.y, left: ripple.x, width: ripple.size, height: ripple.size, animationDuration: `${duration}ms` }}
            />
          );
        })}
    </div>
  );
};


// The main Sign-in Page Component
export default function SignInPage() {
  return (
    <main className="flex items-center justify-center min-h-screen w-full transition-colors duration-300">
      
      {/* The main card with Neumorphic and Glassmorphic effects */}
      <div className="
        w-full max-w-md p-8 sm:p-12 space-y-8 rounded-4xl 
        
        // Light Mode: Neumorphism
        bg-light-bg shadow-soft-raised
        
        // Dark Mode: Glassmorphism
        dark:bg-white/10 dark:shadow-soft-raised dark:backdrop-blur-xl dark:border dark:border-white/20
        
        transition-all duration-300
      ">

        <header className="text-center">
          <h1 className="text-4xl sm:text-5xl font-bold text-foreground">Welcome</h1>
          <p className="mt-2 text-foreground/80">Sign in to access your tests</p>
        </header>

        <form className="space-y-6">
          
          {/* Username Input */}
          <div className="relative">
            <input 
              type="text" 
              id="username"
              placeholder="Username" 
              className="
                w-full px-6 py-4 rounded-full
                font-medium text-foreground placeholder:text-foreground/60
                
                // Light Mode: Inset Neumorphism
                bg-transparent shadow-soft-inset
                
                // Dark Mode: Glassy input
                dark:bg-black/20 dark:shadow-none dark:border dark:border-white/20
                
                focus:outline-none focus:ring-2 focus:ring-accent
                transition-all duration-300
              " 
            />
          </div>

          {/* Password Input */}
          <div className="relative">
            <input 
              type="password" 
              id="password"
              placeholder="Password" 
              className="
                w-full px-6 py-4 rounded-full
                font-medium text-foreground placeholder:text-foreground/60
                
                bg-transparent shadow-soft-inset
                dark:bg-black/20 dark:shadow-none dark:border dark:border-white/20
                
                focus:outline-none focus:ring-2 focus:ring-accent
                transition-all duration-300
              " 
            />
          </div>

          {/* Sign In Button */}
          <div className="pt-4">
            <button 
              type="submit"
              className="
                relative w-full h-16 rounded-full
                text-lg font-bold text-white
                
                // Background
                bg-accent
                
                // Light Mode Shadow
                shadow-soft-raised
                
                // Dark Mode Glow (applied via shadow)
                dark:shadow-soft-raised
                
                // Interaction states
                hover:shadow-soft-hover 
                dark:hover:shadow-soft-raised // Keep glow consistent on hover
                active:shadow-soft-inset
                dark:active:scale-[0.98] dark:active:shadow-none
                
                transition-all duration-200
              "
            >
              Sign In
              <Ripple />
            </button>
          </div>

        </form>

      </div>
    </main>
  );
}
