/* eslint-disable @next/next/no-img-element */

// ===== MOCK DATA (for demonstration purposes) =====
const mockResults = {
  testTitle: "Bài kiểm tra cuối kỳ môn Lịch sử",
  score: "8/10",
  questions: [
    {
      id: 1,
      questionText: "Chiến dịch Điện Biên Phủ diễn ra vào năm nào?",
      userAnswer: "1954",
      correctAnswer: "1954",
      isCorrect: true,
      explanation: "Chiến dịch Điện Biên Phủ là trận đánh lớn nhất trong Chiến tranh Đông Dương lần thứ nhất, diễn ra từ ngày 13 tháng 3 đến ngày 7 tháng 5 năm 1954."
    },
    {
      id: 2,
      questionText: "Vị vua nào đã dời đô từ Hoa Lư về thành Đại La và đổi tên thành Thăng Long?",
      userAnswer: "Lý Thái Tổ",
      correctAnswer: "Lý Thái Tổ",
      isCorrect: true,
      explanation: "Năm 1010, vua Lý Thái Tổ đã quyết định dời đô về thành Đại La và đặt tên mới là Thăng Long, mở ra một kỷ nguyên phát triển cho đất nước."
    },
    {
      id: 3,
      questionText: "Ai là tác giả của 'Bình Ngô đại cáo'?",
      userAnswer: "Lê Lợi",
      correctAnswer: "Nguyễn Trãi",
      isCorrect: false,
      explanation: "'Bình Ngô đại cáo' được viết bởi Nguyễn Trãi theo lệnh của vua Lê Lợi, được xem là bản tuyên ngôn độc lập thứ hai của Việt Nam."
    },
  ],
};


// ===== UI COMPONENTS =====

const Card = ({ children, className = "" }: { children: React.ReactNode, className?: string }) => (
  <div
    className={`
      w-full rounded-3xl p-6 md:p-8
      bg-gradient-to-br from-background via-background to-background/80
      text-foreground shadow-neumorphic
      ${className}
    `}
  >
    {children}
  </div>
);

const StatusBadge = ({ isCorrect }: { isCorrect: boolean }) => (
  <div
    className={`
      rounded-full px-4 py-1 text-sm font-bold
      ${isCorrect ? "bg-green-500/20 text-green-800" : "bg-red-500/20 text-red-800"}
    `}
  >
    {isCorrect ? "Đúng" : "Sai"}
  </div>
);

const Answer = ({ title, text, variant }: { title: string, text: string, variant: 'user' | 'correct' }) => (
   <div className={`p-4 rounded-xl ${variant === 'correct' ? 'bg-green-500/10' : 'bg-red-500/10'}`}>
        <p className="text-sm font-semibold text-foreground/60">{title}</p>
        <p className="text-lg font-medium text-foreground">{text}</p>
    </div>
);


// ===== RESULTS DETAIL PAGE COMPONENT =====

export default function ResultDetailsPage() {
  return (
    <div className="flex min-h-screen w-full justify-center p-4 sm:p-6 lg:p-8 bg-background font-sans">
      <div className="w-full max-w-4xl space-y-8">

        {/* Header */}
        <header className="space-y-2">
          <h1
            className="text-[var(--font-size-lg)] font-bold tracking-tighter text-foreground"
            style={{ lineHeight: 1.2 }}
          >
            {mockResults.testTitle}
          </h1>
          <p className="text-2xl font-semibold text-accent">
            Tổng điểm: {mockResults.score}
          </p>
        </header>

        {/* List of Question Blocks */}
        <main className="space-y-6">
          {mockResults.questions.map((q, index) => (
            <Card key={q.id}>
              <div className="flex flex-col gap-4">
                {/* Question Header */}
                <div className="flex items-center justify-between gap-4">
                  <h2 className="text-xl font-bold text-foreground">
                    Câu hỏi {index + 1}
                  </h2>
                  <StatusBadge isCorrect={q.isCorrect} />
                </div>

                {/* Question Body */}
                <p className="text-lg text-foreground/90">{q.questionText}</p>

                {/* Answers Section */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    {q.isCorrect ? (
                        <Answer title="Câu trả lời của bạn" text={q.userAnswer} variant="correct" />
                    ) : (
                        <>
                            <Answer title="Câu trả lời của bạn" text={q.userAnswer} variant="user" />
                            <Answer title="Đáp án đúng" text={q.correctAnswer} variant="correct" />
                        </>
                    )}
                </div>

                {/* Explanation */}
                {q.explanation && (
                    <div className="pt-2">
                        <p className="font-bold text-lg">Giải thích:</p>
                        <p className="text-foreground/80">{q.explanation}</p>
                    </div>
                )}
              </div>
            </Card>
          ))}
        </main>

      </div>
    </div>
  );
}
