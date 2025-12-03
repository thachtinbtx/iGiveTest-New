/* eslint-disable @next/next/no-img-element */

// ===== NEUMORPHIC UI COMPONENTS (specific for this page) =====

// Input Component with Inset Shadow
const Input = ({
  id,
  type,
  placeholder,
  icon,
}: {
  id: string;
  type: string;
  placeholder: string;
  icon: React.ReactNode;
}) => (
  <div className="relative">
    <div className="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2">
      {icon}
    </div>
    <input
      id={id}
      name={id}
      type={type}
      placeholder={placeholder}
      className="
        w-full rounded-xl border-none bg-transparent pl-12 pr-4 py-4
        text-lg text-foreground placeholder:text-foreground/50
        shadow-neumorphic-inset
        transition-all duration-200
        focus:outline-none focus:ring-4 focus:ring-accent/50
      "
    />
  </div>
);

// Primary Raised Button
const Button = ({
  children,
  type = "button",
  fullWidth = false,
}: {
  children: React.ReactNode;
  type?: "button" | "submit";
  fullWidth?: boolean;
}) => (
  <button
    type={type}
    className={`
      group relative flex h-14 items-center justify-center rounded-2xl 
      px-8 font-semibold text-white bg-accent
      transition-all duration-200 focus:outline-none 
      focus:ring-4 focus:ring-accent/50
      shadow-neumorphic hover:shadow-neumorphic-hover active:shadow-neumorphic-inset
      ${fullWidth ? "w-full" : "min-w-[180px]"}
    `}
  >
    {children}
  </button>
);

// Secondary Flat/Subtle Button
const SecondaryButton = ({
  children,
  fullWidth = false,
}: {
  children: React.ReactNode;
  fullWidth?: boolean;
}) => (
  <button
    type="button"
    className={`
      group relative flex h-14 items-center justify-center rounded-2xl 
      px-8 font-semibold text-foreground
      transition-all duration-200 focus:outline-none 
      focus:ring-4 focus:ring-accent/50
      shadow-neumorphic hover:shadow-neumorphic-hover active:shadow-neumorphic-inset
      bg-background
      ${fullWidth ? "w-full" : "min-w-[180px]"}
    `}
  >
    {children}
  </button>
);

// Main Card container
const Card = ({ children }: { children: React.ReactNode }) => (
  <div
    className="
      w-full rounded-3xl p-8 md:p-12
      bg-gradient-to-br from-background via-background to-background/80
      text-foreground shadow-neumorphic
    "
  >
    {children}
  </div>
);


// ===== LOGIN PAGE COMPONENT =====

export default function LoginPage() {
  const UserIcon = (
    <svg className="h-6 w-6 text-foreground/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
  );

  const LockIcon = (
    <svg className="h-6 w-6 text-foreground/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    </svg>
  );

  return (
    <div className="flex min-h-screen w-full items-center justify-center p-4 bg-background font-sans">
      <div className="w-full max-w-4xl">
        <main>
          <Card>
            <div className="grid grid-cols-1 md:grid-cols-2 md:gap-12">
              
              {/* Left Column: Login Form */}
              <div className="flex flex-col justify-center">
                <header className="mb-8 text-center">
                  <h1 className="text-4xl font-bold tracking-tighter text-foreground">
                    Đăng nhập
                  </h1>
                  <p className="mt-2 text-lg text-foreground/70">
                    Chào mừng quay trở lại!
                  </p>
                </header>

                <form className="space-y-6">
                  <div className="space-y-2">
                    <label htmlFor="username" className="text-lg font-semibold text-foreground">Tên đăng nhập</label>
                    <Input id="username" type="text" placeholder="Nhập tên đăng nhập..." icon={UserIcon} />
                  </div>

                  <div className="space-y-2">
                     <label htmlFor="password" className="text-lg font-semibold text-foreground">Mật khẩu</label>
                    <Input id="password" type="password" placeholder="••••••••" icon={LockIcon} />
                  </div>

                  <div className="pt-4 space-y-4">
                    <Button type="submit" fullWidth>
                      Đăng nhập
                    </Button>
                    <SecondaryButton fullWidth>
                      Đăng nhập với tư cách khách
                    </SecondaryButton>
                  </div>
                </form>
              </div>

              {/* Right Column: Info & Links */}
              <div className="flex flex-col justify-center gap-8 pt-12 md:pt-0">
                 <div className="text-center md:text-left text-lg text-foreground/80">
                    <p>
                        Đây là hệ thống thi trực tuyến được thiết kế với giao diện thân thiện, hiện đại.
                    </p>
                </div>
                
                <div className="rounded-2xl border-l-4 border-accent p-6 shadow-neumorphic-inset">
                    <h3 className="font-bold text-xl text-accent mb-2">Chưa có tài khoản?</h3>
                    <p className="mb-4 text-foreground/80">
                        Đăng ký ngay để bắt đầu tham gia các bài kiểm tra và theo dõi tiến độ học tập của bạn.
                    </p>
                    <a href="#" className="font-bold text-accent hover:underline">Đăng ký ngay →</a>
                </div>

                <div className="text-center md:text-left">
                    <a href="#" className="font-semibold text-foreground/70 hover:text-accent hover:underline">
                        Quên mật khẩu?
                    </a>
                </div>
              </div>

            </div>
          </Card>
        </main>
      </div>
    </div>
  );
}
