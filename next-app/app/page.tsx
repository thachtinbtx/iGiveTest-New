/* eslint-disable @next/next/no-img-element */

// Reusable component definitions for clarity and consistency

const Card = ({
  children,
  className = "",
}: {
  children: React.ReactNode;
  className?: string;
}) => (
  <div
    className={`
      flex flex-col gap-6 rounded-3xl p-8
      bg-gradient-to-br from-background via-background to-background/80
      text-foreground shadow-neumorphic
      transition-all duration-300
      ${className}
    `}
  >
    {children}
  </div>
);

const Button = ({
  children,
  variant = "primary",
}: {
  children: React.ReactNode;
  variant?: "primary" | "secondary";
}) => (
  <button
    className={`
      group relative flex h-14 min-w-[180px] items-center 
      justify-center rounded-2xl px-6 font-semibold
      transition-all duration-200 focus:outline-none 
      focus:ring-4 focus:ring-accent/50
      
      shadow-neumorphic hover:shadow-neumorphic-hover active:shadow-neumorphic-inset
      
      ${variant === "primary" ? "bg-accent text-white" : "bg-background text-foreground"}
    `}
  >
    {children}
  </button>
);

export default function Home() {
  return (
    <div className="flex min-h-screen w-full items-center justify-center p-4 sm:p-6 lg:p-8 bg-background font-sans">
      <div className="w-full max-w-xl">
        {/* Header */}
        <header className="mb-8 text-center">
          <h1
            className="text-[var(--font-size-lg)] font-bold tracking-tighter text-foreground"
            style={{ lineHeight: 1.2 }}
          >
            Neumorphic UI
          </h1>
          <p className="mt-2 text-lg text-foreground/70">
            A demonstration of the Soft UI / Neumorphism style.
          p>
        </header>

        {/* Main Card */}
        <main>
          <Card>
            <h2 className="text-2xl font-bold">Content Card</h2>
            <p className="text-foreground/80">
              This card and the buttons below demonstrate the Neumorphic style,
              with soft, dual-layer shadows creating a raised, physical effect.
            </p>
            <div className="flex flex-col items-center gap-6 pt-4 sm:flex-row sm:justify-center">
              <Button variant="primary">Primary Action</Button>
              <Button variant="secondary">Secondary Action</Button>
            </div>
          </Card>
        </main>
      </div>
    </div>
  );
}
