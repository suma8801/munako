document.addEventListener('DOMContentLoaded', () => {
  // クエリパラメータから結果を取得して表示
  const params = new URLSearchParams(window.location.search);

  // 天命のデータの取得と表示
  const destiny = params.get('destiny');
  if (destiny) {
    // 以下のように直接、HTML要素に値を設定する
    if (destiny === '1') {
      document.getElementById('destiny-title').innerHTML = '魔術師<br>(THE MAGICIAN)';
      document.getElementById('destiny-image').src = 'image/bk/1.png';
      document.getElementById('destiny-short-text').innerHTML = '皆が欲しいものを何でも生み出し創りたい！<br>凄腕の魔法使い';
      document.getElementById('destiny-long-text').innerHTML = '『人をアッと驚かせたい、魔法のように新しいものや皆が欲しいものを創り出したい。そして「凄い！」と言われたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「魔術師」が天命の人は、子どもの頃から色んなことができるようになりたいと思ったり、勉強したことや覚えたことを人前で披露してみたり、それを褒められるとすごく嬉しい！という経験をたくさんしています。タロットカードの「魔術師」は、テーブルの上にある４つのアイテムを使い『私はこの手でどんなものでもあっという間に創ることができるんだ！』と錬金術を見せて、目の前にいる大勢の村人達を驚かせ、拍手喝采を浴びます。クリエイティブなことが好きなあなたは、どんな才能を使って人々を驚かせ、「凄い！」と言われる道を歩いていくのでしょうか。';
    }
    if (destiny === '2') {
      document.getElementById('destiny-title').innerHTML = '女教皇<br>(THE HIGH PRIESTESS)';
      document.getElementById('destiny-image').src = 'image/bk/2.png';
      document.getElementById('destiny-short-text').innerHTML = '人と人とを繋げて幸せな人を増やしたい！<br>直観のコネクター';
      document.getElementById('destiny-long-text').innerHTML = '『人と人とを繋げたい、そこから新しい何かが生まれるのを見たい。いろんなことを知って世界中のあらゆるものと繋がりたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「女教皇」が天命の人は、子どもの頃から知りたがり屋さんでした。乾いた砂が水を吸うように、大人になってもいろんなことが知りたくて興味が尽きず、習い事や勉強をします。その中で人との繋がりが増え、あの人とこの人、仲良くなったらいいかも！と考え、人に人を紹介します。繋がっていくのが心底嬉しいのです。タロットカードの「女教皇」は、宇宙のすべてが書かれているという書物を抱えて、無意識の領域で光と影、陰と陽の橋渡しをしています。目立つことは望まず、静かに人の役に立つのが好きなあなたは、どんな才能を使って人と人とを繋げ、世界中を平和に幸せにしていくのでしょうか。';
    }
    if (destiny === '3') {
      document.getElementById('destiny-title').innerHTML = '女帝<br>(THE EMPRESS)';
      document.getElementById('destiny-image').src = 'image/bk/3.png';
      document.getElementById('destiny-short-text').innerHTML = '溢れるアイデアを披露して皆から<br>愛されチヤホヤされたい！<br>お姫様（プリンス）';
      document.getElementById('destiny-long-text').innerHTML = '『周りのすべての人から愛され大切にされ、チヤホヤされたい。何不自由なく豊かで、愛情あふれる暮らしがしたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「女帝」が天命の人は、子どもの頃からお姫様や王子様のようなポジションを求めています。自分は特に何もしなくても、皆が私のために動いてくれたら嬉しい！と思っています。頭の中に浮かんだちょっとしたアイデアや思いつきを話すと、「凄い！」と言われて、皆がそのアイデアが現実になるように動いてくれた経験はありませんか？周囲の皆が私のために頑張ってくれる。女帝が天命の人は、それでいいのです。タロットカードの「女帝」は、豊かな自然に囲まれ、周りの人々から愛され、ソファにゆったりと腰かけて微笑んでいます。私が幸せだと皆も幸せ、それが天命のあなたは、どんな才能を使って全世界の人から愛され大切にされ、チヤホヤされる人生を歩むのでしょうか。';
    }
    if (destiny === '4') {
      document.getElementById('destiny-title').innerHTML = '皇帝<br>(THE EMPEROR)';
      document.getElementById('destiny-image').src = 'image/bk/4.png';
      document.getElementById('destiny-short-text').innerHTML = '多くの人が安心して生きていける土台を創りたい！<br>トップに立つリーダー';
      document.getElementById('destiny-long-text').innerHTML = '『皆が安全で安心して暮らせるようなシステムや土台を作りたい、その基盤が半永久的に続くようにしっかりと運営していきたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「皇帝」が天命の人は、子どもの頃から「どうやったら皆がうまくいくかな？」「どうやったらこれがスムーズにいくかな？」ということを考えて工夫をしてきました。自分だけのことより周り全体のことを考えます。タロットカードの「皇帝」は、砂漠の中の冷たい石の椅子に座り、自分が管理する国が安心で安全に暮らせる状態が続くように、淡々とやるべきことをやり続けます。社長業や、どこかの組織のリーダー、コミュニティのまとめ役にふさわしいあなたは、どんな才能を使って皆が安心して過ごせる基盤やシステムを作り、社会に貢献していくのでしょうか。';
    }
    if (destiny === '5') {
      document.getElementById('destiny-title').innerHTML = '法王<br>(THE HIEROPHANT)';
      document.getElementById('destiny-image').src = 'image/bk/5.png';
      document.getElementById('destiny-short-text').innerHTML = 'すべての人が生きやすい世の中にしたい。<br>厳しくも慈愛に満ちた教育者';
      document.getElementById('destiny-long-text').innerHTML = '『どんな人にとっても生きやすい世の中にしたい。ひとりひとりに居場所がある社会を作りたい。そんな社会を支える人を育てたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「法王」が天命の人は、子どもの頃から人生について考えたり、悩み事の相談を買ってでたりしてきました。そのうちに対大勢に、自分らしく生きるために大切なことを教えたい、伝えたい、と思うようになってきたのです。タロットカードの「法王」は、広くあまねく人々に、社会の一員として立派に生きていくための説法をします。つい深い話を語ってしまうあなたは、どんな才能を使って皆が生きやすい、すべての人に居場所がある社会を作り、人々を育てていくのでしょうか。';
    }
    if (destiny === '6') {
      document.getElementById('destiny-title').innerHTML = '恋人たち<br>(THE LOVERS)';
      document.getElementById('destiny-image').src = 'image/bk/6.png';
      document.getElementById('destiny-short-text').innerHTML = '気の向くまま遊ぶように今を生きたい奔放な自由人';
      document.getElementById('destiny-long-text').innerHTML = '『人生楽しまなきゃ。難しく考えずラクに生きよう。いくつになっても恋をしよう。自由気ままに今を生きよう』。あなたは「人生を遊び尽くして思いっきり楽しもう！」と決めて、この世界に生まれてきました。「恋人たち」が天命の人は、子どもの頃から自由気ままでいたい、遊んで暮らしたい、と思っています。タロットカードの「恋人たち」には、エデンの園にいるアダムとイヴが天使に祝福されているシーンが描かれています。二人は裸でいても羞恥心はなく無垢のまま。労働する必要もなく楽園で幸せに暮らしています。ちゃんとする、ひとつのことを長く続ける、といったことが人生の目的には「無い」あなた。日本では生きにくいかもしれませんね。本能の欲求に忠実に生きたいあなたは、どんな才能を使って人生を楽園のように生きていくのでしょうか。';
    }
    if (destiny === '7') {
      document.getElementById('destiny-title').innerHTML = '戦車<br>(THE CHARIOT)';
      document.getElementById('destiny-image').src = 'image/bk/7.png';
      document.getElementById('destiny-short-text').innerHTML = '誰にも邪魔はさせない！<br>我が道を行く情熱の戦士';
      document.getElementById('destiny-long-text').innerHTML = '『誰にも邪魔されず自分の信じた道を突き進みたい。そしてどんな戦いにも勝つんだ』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「戦車」が天命の人は、子どもの頃から人の言うことは聞きたくない、自分の意思を貫き通したい！と思って生きてきました。親だろうと先生だろうと立派な人だろうと、自分の中の熱い思いを止めることができないのです。タロットカードの「戦車」には、若い王子が国王である父親の反対を押し切って勇ましく戦いに出陣するシーンが描かれています。自分の内側にある「強気」な自分と「弱気」な自分。相反する気持ちをどうにかコントロールしたいあなたは、どんな才能を使って自分の意思を貫き通し、勝ち戦を続けていくのでしょうか。';
    }
    if (destiny === '8') {
      document.getElementById('destiny-title').innerHTML = '力<br>(STRENGTH)';
      document.getElementById('destiny-image').src = 'image/bk/8.png';
      document.getElementById('destiny-short-text').innerHTML = 'どんな不可能も可能にしたい！<br>愛の力で奇跡を起こす人';
      document.getElementById('destiny-long-text').innerHTML = '『世の中の不条理を変えたい。不可能と言われることを可能にしたい。そして世の中に奇跡を起こしたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「力」が天命の人は、子どもの頃から“そんなのムリだよ”“止めた方がいいよ”と言われ続けているはず。でも、言われれば言われるほど「やりたい！」という気持ちがふつふつと湧いてきて行動を起こしてきました。だからこそ、奇跡を起こせるのです。タロットカードの「力」には、獰猛（どうもう）なライオンを猫のように手なずけている女性が描かれています。そこには、腕力としてのパワーではなく愛の力があるのです。ムリだ無謀だ、と言われることほどチャレンジしたいあなたは、どんな才能を使って不可能を可能に変えて奇跡を起こしていくのでしょうか。';
    }
    if (destiny === '9') {
      document.getElementById('destiny-title').innerHTML = '隠者<br>(THE HERMIT)';
      document.getElementById('destiny-image').src = 'image/bk/9.png';
      document.getElementById('destiny-short-text').innerHTML = '人生に迷う人に寄り添って導きたい。<br>心優しき孤高の賢者';
      document.getElementById('destiny-long-text').innerHTML = '『人生に迷った人に寄り添いたい。そして自分の道をしっかり歩いて行けるよう人々を導いてあげたい』。あなたはそんな風に生きようと決めて、この世界に生まれてきました。「隠者」が天命の人は、子どもの頃から人の相談に乗ったり、哲学や人生についてひとり考える時間を多く過ごしてきました。本、漫画、映画であらゆる人生を疑似体験し、自分自身の経験や体験も重ね、それらすべての学びを人のために活かしたいと思っています。タロットカードの「隠者」は、山奥にひとりでいる老人です。ランプを手にして山に迷い込んだ旅人を待ち、道案内をするのです。この山は人生の山。迷い人ひとりひとりに寄り添いたいあなたは、どんな才能を使って迷い人を導いていくのでしょうか。';
    }
  }
  // 才能のデータの取得と表示
  const talent = params.get('talent');
    if (talent) {
      if (talent === '0') {
        document.getElementById('talent-title').innerHTML = '愚者<br>(THE FOOL)';
        document.getElementById('talent-image').src = 'image/bk/0.png';
        document.getElementById('talent-short-text').innerHTML = '無限の可能性を秘めた自由気ままな冒険者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、頭の中でいろいろ考えることなく、無の状態で行動できる人。天真爛漫で無防備で、まさに赤ちゃんのように無限の可能性で溢れています。生まれながらに固定観念や囚われのないあなたは、どんな状況であろうと誰を相手にしようと自由気ままでいられます。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '1') {
        document.getElementById('talent-title').innerHTML = '魔術師<br>(THE MAGICIAN)';
        document.getElementById('talent-image').src = 'image/bk/1.png';
        document.getElementById('talent-short-text').innerHTML = '何でもできるマルチ人間、誰もが驚く凄腕魔法使い';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、あっという間に何でもできてしまうマルチ人間。少し習っただけでコツを掴み、もう何年もやっているかのような貫禄を漂わせたり、人がハッとするようなことを言ったりします。その姿は人目を引き、意識せずとも注目を浴びます。人をアッと驚かせる技術を生まれながらにして持っているあなたは、一瞬にして人の心を掴み「凄い」と思わせることができます。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '2') {
        document.getElementById('talent-title').innerHTML = '女教皇<br>(THE HIGH PRIESTESS)';
        document.getElementById('talent-image').src = 'image/bk/2.png';
        document.getElementById('talent-short-text').innerHTML = '宇宙の法則を生まれながらに知る知的なコネクター';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、無意識の領域に強い人。思考や常識で動くと途中でつまずき、直感で動く方がうまくいきます。「この人とこの人を会わせるといいかも！」とピンときて、新しい出会いを作っていきます。繋いだ人同士の新しい動きやコラボレーションで、世の中に貢献しています。生まれながらに影の功労者であるあなたは、多くの人から感謝され、直接関わらない人にまで影響を及ぼします。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '3') {
        document.getElementById('talent-title').innerHTML = '女帝<br>(THE EMPRESS)';
        document.getElementById('talent-image').src = 'image/bk/3.png';
        document.getElementById('talent-short-text').innerHTML = '皆からチヤホヤされて愛される、アイデアとひらめきの神様';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、人から無条件に愛される人。ふとした瞬間に浮かぶアイデアや思いつきを口にすると皆が喜び、それを実現しようと動いてくれます。その間あなたは何もせず座っていても大丈夫。ニコニコと笑顔を浮かべながら待っていると、自分も皆も喜ぶような結果になります。困ったらいつだって人が助けてくれて、何だか申し訳ないな、と思わなくもないけれど「ま、いっか」と朗らかに笑うあなたは、生まれながらのお姫様（王子様）。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '4') {
        document.getElementById('talent-title').innerHTML = '皇帝<br>(THE EMPEROR)';
        document.getElementById('talent-image').src = 'image/bk/4.png';
        document.getElementById('talent-short-text').innerHTML = '周囲から一目置かれる信頼と安定のトップリーダー';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、冷静に客観的に物事を捉え、目標に向かって行動できる人。皆が安全で安心して暮らしていけるシステムや土台を作るのが得意で、その基盤が半永久的に続くよう、人を采配しながら守り続けています。生まれながらのリーダーであるあなたは、自分だけのことより全体を考え、皆のために黙々と必要な土台を構築します。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '5') {
        document.getElementById('talent-title').innerHTML = '法王<br>(THE HIEROPHANT)';
        document.getElementById('talent-image').src = 'image/bk/5.png';
        document.getElementById('talent-short-text').innerHTML = '社会に通用する人を育てる、厳しくも慈愛に満ちた教育者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、関わる人すべてに、社会で自分の居場所を見つけて生きていけるよう、厳しくも愛を持って世の中を生きていくためのルールを教えることができる、生まれながらの「先生」です。一言話すと「元気が出る」「いいことを教えてもらった」と有難がられるあなたは、多くの人に「人生に役立つこと」を分かりやすく教えたり伝えたりすることが得意。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '6') {
        document.getElementById('talent-title').innerHTML = '恋人たち<br>(THE LOVERS)';
        document.getElementById('talent-image').src = 'image/bk/6.png';
        document.getElementById('talent-short-text').innerHTML = 'この世は楽園。今を生き、遊び楽しみながら自分も人も歓ばせる奔放な自由人';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、どんな時代に生きていても「この世は楽園」とばかりに遊び楽しみながら自分を歓ばせることができる、生まれながらの自由人。難しく考えると思考がストップしてしまうあなたは、「世間の常識」や「普通」を超えて、本能のまま自由自在に人生を楽しむことができます。「ちゃんとしなきゃ」という価値観がないあなたは、人生そのものが遊びだから、仕事も恋愛も楽しさの延長線上にあり、いくつになっても若々しく魅力的。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '7') {
        document.getElementById('talent-title').innerHTML = '戦車<br>(THE CHARIOT)';
        document.getElementById('talent-image').src = 'image/bk/7.png';
        document.getElementById('talent-short-text').innerHTML = '考えるより動く。我が道を進み勝利をもたらす戦士';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、生まれながらの「考えるより動く」人。自分の中の熱い思いに従って、どんな時も真っすぐに目標に向かって進みます。子どもの頃から人の言うことに聞く耳を持たないあなたは、親だろうと先生だろうと立派な人だろうと、誰かの言いなりになることはなく、自分の中の熱い思いを真っすぐに行動に移せるのです。自分の内側にある「強気」な自分と「弱気」な自分。相反する気持ちをコントロールしながら、誰にも邪魔させず前へ進んでいく。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '8') {
        document.getElementById('talent-title').innerHTML = '力<br>(STRENGTH)';
        document.getElementById('talent-image').src = 'image/bk/8.png';
        document.getElementById('talent-short-text').innerHTML = 'どんな不可能をも可能にする奇跡の人';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、どんな困難なことも時間をかけてじっくり取り組む人。その結果、「ムリ」「難しい」ことを「できた」「やれた」に変えてきました。子どもの頃からあなたは、“そんなのやってもムダだよ”“止めた方がいいよ”と言われることにチャレンジし、数々の奇跡を起こしてきました。それはあなたが、人を無理やり押さえつけたり、無理強いしたりせず、根気と愛の力で行動しているからです。生まれながらに不可能を可能にする人。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '9') {
        document.getElementById('talent-title').innerHTML = '隠者<br>(THE HERMIT)';
        document.getElementById('talent-image').src = 'image/bk/9.png';
        document.getElementById('talent-short-text').innerHTML = '人生に迷った人に寄り添い導く孤高の賢者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、悩んでいる人に的確なアドバイスができる人。悩み苦しんでいる人達の年齢はさまざま。そんな人々の心に伝わる言葉や表現を自然に使い分け、その先の人生を照らします。子どもの頃から当たり前のように人の相談に乗ってきたあなたは、まさに生まれながらの「救い人」。ひとりひとりに寄り添いその人だけの答えを提示し、導いていく。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '10') {
        document.getElementById('talent-title').innerHTML = '運命の輪<br>(WHEEL OF FPRTUNE)';
        document.getElementById('talent-image').src = 'image/bk/10.png';
        document.getElementById('talent-short-text').innerHTML = 'チャネリングして「時」と「運」を操る先駆者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、生まれながらに自然とタイミングを計り「強運」に乗っている人。人よりも二歩三歩、先を進むあなたは、自分の直感や感覚で「旬」を掴み、自分の腕で人生の舵を切っています。子どもの頃から、人よりも何かを掴むのが早かったり、運がいいな、と思うことが多いはず。それは天につながりチャネリングしているから。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '11') {
        document.getElementById('talent-title').innerHTML = '正義<br>(JUSTICE)';
        document.getElementById('talent-image').src = 'image/bk/11.png';
        document.getElementById('talent-short-text').innerHTML = '公平に冷静に判断を下す、正真正銘の正義の味方';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、嘘を見抜き、全てを見通し、感情に動かされず、容赦なく、合理的に冷静に、公平に判断を下す人です。真実以外はどんなにお願いされても説得されても、賄賂すら通用しません。間違っていると思うことは、とことん追求し正義を貫くからです。まさに生まれながらの「正義の味方」。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '12') {
        document.getElementById('talent-title').innerHTML = '吊るされた男<br>(THE HANGED MAN)';
        document.getElementById('talent-image').src = 'image/bk/12.png';
        document.getElementById('talent-short-text').innerHTML = '目先の利に惑わされない生まれながらの悟り人';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、修行僧のようにじっと試練に耐えることができる人。生まれながらに「欲しいものほど人に譲るとそれ以上のものが還ってくる」という宇宙の原理原則を知っているあなたは、子どもの頃から目先の利に囚われずに物事を判断していました。時に自己犠牲にも思える行動をとりますが、最終的にはそれ以上のものを得ている。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '13') {
        document.getElementById('talent-title').innerHTML = '死神<br>(DEATH)';
        document.getElementById('talent-image').src = 'image/bk/13.png';
        document.getElementById('talent-short-text').innerHTML = '感情に左右されない、完璧な感情コントローラー';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、「時」が来たらバッサリと「切る」人。感情に左右されずあっさり、サッパリとしていて、情に流されることもほとんどありません。人・モノ・コトには必ず別れがあり、それは「魂の解放」だと子どもの頃から知っているからです。あなたは生まれながらにしてバッサリと潔く人間関係を終わらせて、新しいことを始められる人。そこに遺恨も後悔も罪悪感もない。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '14') {
        document.getElementById('talent-title').innerHTML = '節制<br>(TEMPERANCE)';
        document.getElementById('talent-image').src = 'image/bk/14.png';
        document.getElementById('talent-short-text').innerHTML = '自律と節度と瑞々しさ。抜群の安定感と浄化の※バランサー　※調和をとる役目を担う人';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、目立たず控えめながらも非凡で凄い人。規則正しくコツコツとした作業が得意だったり、穏やかで自分を律することができます。いるだけで人を安心させてしまうあなたは、心の中に淀みが少なく、異質な空間にいても自分自身を仲介して浄化していくのです。生まれながらに自分も周りも浄化して整える人。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '15') {
        document.getElementById('talent-title').innerHTML = '悪魔<br>(THE DEVIL)';
        document.getElementById('talent-image').src = 'image/bk/15.png';
        document.getElementById('talent-short-text').innerHTML = '目が合えば人を沼らせる。魅力的な人たらし';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、存在するだけで強烈に人を惹きつけてしまう魅惑の人。誰かに好かれたいと思って行動しているわけではないのに、多くの人から熱狂的に好かれてしまいます。「去る者追わず来る者拒まず」でいるだけなのに、簡単に人が沼ってしまう。それは人の心に巣くう「欲望」を自在に操れるから。まさに生まれながらの「小悪魔」。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '16') {
        document.getElementById('talent-title').innerHTML = '塔<br>(THE TOWER)';
        document.getElementById('talent-image').src = 'image/bk/16.png';
        document.getElementById('talent-short-text').innerHTML = '人生七転び八起。原点に還って新しいステージを創る、スクラップ＆ビルダー';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、生まれながらの「スクラップ＆ビルダー」。自分の弱さを肯定し、それをモチベーションにできる人。そもそも人間は慢心して奢り高ぶってしまう存在。物事や関係性は永遠ではなく、どこかでねじれや歪みが生じる。あなたはそんな「腐った」ものを自ら破壊し、皆のために次のステージを用意します。原点に還るからこそ、大切（だと思っている）ものを執着なく壊すことができるのです。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '17') {
        document.getElementById('talent-title').innerHTML = '星<br>(THE STAR)';
        document.getElementById('talent-image').src = 'image/bk/17.png';
        document.getElementById('talent-short-text').innerHTML = '皆の憧れカリスマ的存在、煌めく星のようなまさにスター';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、存在そのものが光り輝くスターのような人。子どもの頃から優等生でカリスマ的存在。価値観は清く正しく美しく、世の中も理想的で平和であって欲しいと願っています。特別なことをしているわけではないけれど、皆が「あんな風になりたい」と憧れのまなざしであなたを見ています。それはあなたの言葉や行動が理想的で美しいから。生まれながらの煌めくスター。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '18') {
        document.getElementById('talent-title').innerHTML = '月<br>(THE MOON)';
        document.getElementById('talent-image').src = 'image/bk/18.png';
        document.getElementById('talent-short-text').innerHTML = '浄化の光で深淵なるものを癒し真実を見出すヒーラー';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、神秘的で繊細な人。インスピレーションを受けやすく直感派のあなたは、誰もが抱えている心の中の「不安」を肯定し、浄化の光を当てて真実を見出し、複雑な現代社会を生き抜く術を持っています。生まれながらに「癒し」の存在でもあるあなたは、ちょっとした仕草や言葉で人の心を和ませます。それは周囲にどんどん波及していき、そばにいるとホッとする、元気になる…そんな人を増やしていくのです。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '19') {
        document.getElementById('talent-title').innerHTML = '太陽<br>(THE SUN)';
        document.getElementById('talent-image').src = 'image/bk/19.png';
        document.getElementById('talent-short-text').innerHTML = '裏表がなく天真爛漫で真っすぐな姿に元気が湧く天性の人気者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、太陽のように明るく裏表がない人。生まれながらの天真爛漫さから嘘偽りなく人々に接し、子どもの頃から「大いなる存在に守られている」感覚があるおかげで、素直に物事を受けとめ、不安感がほとんどありません。忖度のないストレートな物言いは、時に毒舌と受け取られることもありますが、隠すことなど何もないあなたにはそれが普通。その姿や言葉は、自然に人を勇気づけ、生きるエネルギーを湧き上がらせます。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '20') {
        document.getElementById('talent-title').innerHTML = '審判<br>(JUDGEMENT)';
        document.getElementById('talent-image').src = 'image/bk/20.png';
        document.getElementById('talent-short-text').innerHTML = '立ちはだかる壁に真摯に向き合い、自己を成長させていく魂の求道者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、物事に白黒の決着をハッキリとつける人。自分をごまかしたり、拗ねたりひねくれることがありません。長い人生の中で大きな壁が立ちはだかったとき、これまでの自分の行いに真摯に向き合うことができるあなたは、出来事を通して自分の魂を成長させていきます。そのチャンスから逃げてしまう人も多い中、あなたは良いも悪いも含めて自分にしっかりと向き合える強さを、生まれながらにして持っています。言葉を語らずとも、あなたのその背中が、人々に「自分を赦し再スタートを切る」きっかけを与えます。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
      if (talent === '21') {
        document.getElementById('talent-title').innerHTML = '世界<br>(THE WORLD)';
        document.getElementById('talent-image').src = 'image/bk/21.png';
        document.getElementById('talent-short-text').innerHTML = '普通さの中にある特別感、完璧なのに抜け感、穏やかで調和のとれた魂の成功者';
        document.getElementById('talent-long-text').innerHTML = 'あなたは、生まれながらに魂が整っている人。穏やかで調和のとれた魂を持つあなたは、お金持ちとか貧乏とか、独身か既婚とか、子どもがいるとかいないとか、健康とか不健康とか、友達がどうだとか仕事がどうだとか、そんな条件や環境を超えたところで、心穏やかで幸せな温かい毎日を送っているのではないでしょうか。普通にしているのに特別な何かを感じさせ、そつがないのにほど良い抜け感があり、完璧なのにムリしている感じがまったくない、生まれながらの「魂の成功者」。これこそが他の人にはない、あなたが持って生まれた才能（強み）で武器なのです。';
      }
    }
  // 弱点のデータの取得と表示
  const weakness = params.get('weakness');
    if (weakness) {
      if (weakness === '0') {
        document.getElementById('weakness-title').innerHTML = '愚者<br>(THE FOOL)';
        document.getElementById('weakness-image').src = 'image/bk/0.png';
        document.getElementById('weakness-short-text').innerHTML = '無計画すぎて無責任。その場しのぎで未熟な冒険者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・無計画でルーズ、無責任、深く考えず衝動的に行動する、その場しのぎの言い訳をする、大人になりきれず未熟・・・です。浪費癖がある人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「考えなしの幼稚な人間」と思われます。';
      }
      if (weakness === '1') {
        document.getElementById('weakness-title').innerHTML = '魔術師<br>(THE MAGICIAN)';
        document.getElementById('weakness-image').src = 'image/bk/1.png';
        document.getElementById('weakness-short-text').innerHTML = 'おどおどと自信がなく、力を発揮できない残念な魔法使い';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・消極的で優柔不断、心配性で自分に自信がない、意志が弱い、持てる力を発揮できない・・・です。天性の嘘つきの人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「言うほど大したことない」と思われます。';
      }
      if (weakness === '2') {
        document.getElementById('weakness-title').innerHTML = '女教皇<br>(THE HIGH PRIESTESS)';
        document.getElementById('weakness-image').src = 'image/bk/2.png';
        document.getElementById('weakness-short-text').innerHTML = '自分の利だけを考える、理屈っぽい偏見だらけのコネクター';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・偏見が多い、独断的で理屈っぽい、視野が狭い、機嫌が悪いとイライラする、他人に厳しい・・・です。冷淡で利己主義な人や、うぬぼれが強い人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「神経質で極端」と思われます。';
      }
      if (weakness === '3') {
        document.getElementById('weakness-title').innerHTML = '女帝<br>(THE EMPRESS)';
        document.getElementById('weakness-image').src = 'image/bk/3.png';
        document.getElementById('weakness-short-text').innerHTML = '欲張りでワガママ。不満タラタラの、地に落ちた神様';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・わがまま、怠け者、チヤホヤされないと気が済まない見栄っ張り、贅沢、欲張り、不平不満を漏らす・・・です。浪費癖があったり、浮気常習犯の人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「嫉妬深くて文句言い」と思われます。';
      }
      if (weakness === '4') {
        document.getElementById('weakness-title').innerHTML = '皇帝<br>(THE EMPEROR)';
        document.getElementById('weakness-image').src = 'image/bk/4.png';
        document.getElementById('weakness-short-text').innerHTML = '横暴でワンマン、または意志薄弱で自尊心が低い。裸の王様なトップリーダー';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、横暴でワンマン、傲慢で野心過剰、腕力や立場を使って人を支配する。もうひとつは、意志が弱い、未熟で不安定、自尊心が低い・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「誰も尊敬してないのに本人はまるで分かってない」と思われます。';
      }
      if (weakness === '5') {
        document.getElementById('weakness-title').innerHTML = '法王<br>(THE HIEROPHANT)';
        document.getElementById('weakness-image').src = 'image/bk/5.png';
        document.getElementById('weakness-short-text').innerHTML = '他人に厳しく自分に甘い。頭が堅くて融通の利かない嫌われ者の教育者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・人に厳しく、ケチで出し惜しみをするところ。心が狭く、堅物で柔軟性がない、親切心や人を助ける心が薄い、ひとつの考えに固執して偏ってしまう・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「自分には甘くて人には厳しい、融通の利かない人」と思われます。';
      }
      if (weakness === '6') {
        document.getElementById('weakness-title').innerHTML = '恋人たち<br>(THE LOVERS)';
        document.getElementById('weakness-image').src = 'image/bk/6.png';
        document.getElementById('weakness-short-text').innerHTML = '優柔不断か酒池肉林。倫理という言葉は辞書にない、迷いすぎる自由人';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、優柔不断で迷いやすいく、なかなか答えを出せない。もうひとつは、飽きっぽく物事に無頓着で、気が多い。浮気性で遊びの恋愛をしたり、惰性のままズルズルと関係を引っ張る人がいたり、浪費癖がある人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「軽薄で人でなし」と思われます。';
      }
      if (weakness === '7') {
        document.getElementById('weakness-title').innerHTML = '戦車<br>(THE CHARIOT)';
        document.getElementById('weakness-image').src = 'image/bk/7.png';
        document.getElementById('weakness-short-text').innerHTML = '暴走するか挫折で失敗。コントロールの効かない負け戦の戦士';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、途中で諦めたり挫折する、失敗への恐怖心が強い、勇気がない。もうひとつは、自信過剰で暴走しやすい、人に無理強いをする、衝動的に行動する・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「落ち着きがなく衝動的で自分をコントロールできていない」と思われます。。';
      }
      if (weakness === '8') {
        document.getElementById('weakness-title').innerHTML = '力<br>(STRENGTH)';
        document.getElementById('weakness-image').src = 'image/bk/8.png';
        document.getElementById('weakness-short-text').innerHTML = 'やりたいはずなのに…自分を信じられず諦めてしまう、未熟なチャレンジャー';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・メンタルが弱い、自分に自信がない、うまくいかないと諦めてしまう、長いものに巻かれる、自分も人も受け入れられない、権威に屈服してしまう・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「いくじなしで、すぐにムリって言う」と思われます。';
      }
      if (weakness === '9') {
        document.getElementById('weakness-title').innerHTML = '隠者<br>(THE HERMIT)';
        document.getElementById('weakness-image').src = 'image/bk/9.png';
        document.getElementById('weakness-short-text').innerHTML = '人の気持ちに寄り添わない、偏屈で変わり者の賢者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・偏屈、すぐ疑う、内向的で孤独、出不精、いろいろと考えすぎ、人間不信、誰もわかってくれないと思い込み他人を拒絶する・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「考えすぎで偏屈で孤独な変わり者」と思われます。';
      }
      if (weakness === '10') {
        document.getElementById('weakness-title').innerHTML = '運命の輪<br>(WHEEL OF FPRTUNE)';
        document.getElementById('weakness-image').src = 'image/bk/10.png';
        document.getElementById('weakness-short-text').innerHTML = '時間感覚がズレている…波に乗れない先駆者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・時間感覚が人と違う（遅刻魔）、タイミングを外している感覚、流れに乗れていない、チャンスを掴めない、実力はあるはずなのに芽が出ない、考えすぎると負のループから抜けられない・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「時間にルーズ」「約束を守れない」「言うことがコロコロ変わる」と思われます。';
      }
      if (weakness === '11') {
        document.getElementById('weakness-title').innerHTML = '正義<br>(JUSTICE)';
        document.getElementById('weakness-image').src = 'image/bk/11.png';
        document.getElementById('weakness-short-text').innerHTML = '不公平でズルい、嘘だらけのエセ正義の味方';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・ズルい、自分がルール、好き嫌いや先入観で判断する、ひいきをする、不誠実、人に厳しく自分に甘い・・・です。意志が弱く、詐欺や悪徳商法に巻き込まれる人もいたり、逆に法を守らない、法スレスレの行為をする人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「ズルくて自分さえよければいい人」「意志が弱くて騙されやすい」と思われます。';
      }
      if (weakness === '12') {
        document.getElementById('weakness-title').innerHTML = '吊るされた男<br>(THE HANGED MAN)';
        document.getElementById('weakness-image').src = 'image/bk/12.png';
        document.getElementById('weakness-short-text').innerHTML = '修行の視点がズレていて悟りにはほど遠い、残念な悟り人';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、自虐的で悲観的、報われない苦労ばかり選んでいる、無駄な犠牲を払う。もうひとつは、自分のことばかりで利己的、状況を受け入れられず問題から逃げる、忍耐不足で続かない・・・です。結果的にひきこもりになったり、働かないケースもあります。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「人のせいにして自分で変わろうとしない人」と思われます。';
      }
      if (weakness === '13') {
        document.getElementById('weakness-title').innerHTML = '死神<br>(DEATH)';
        document.getElementById('weakness-image').src = 'image/bk/13.png';
        document.getElementById('weakness-short-text').innerHTML = '感情がゼロまたは振り回され過ぎる、不完全な感情コントローラー';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、別れや何かを失うことへの異常な恐怖感。もうひとつは、人間関係や物事に執着がなさ過ぎてバッサリ切り捨て過ぎるところ。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「いつまでもグズグズ言って潔さがない」または「情け容赦ない冷酷な人」と思われています。';
      }
      if (weakness === '14') {
        document.getElementById('weakness-title').innerHTML = '節制<br>(TEMPERANCE)';
        document.getElementById('weakness-image').src = 'image/bk/14.png';
        document.getElementById('weakness-short-text').innerHTML = '６つのバランスが崩れて機能不全。整わない※バランサー　※調和をとる役目を担う人';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は６つ。ひとつだけ当てはまる人もいれば複数の要素が絡んでいる人もいます。①根気不足でいい加減　②気持ちが不安定で落ち着きがない　③節度がなく無神経　④「氣」が停滞しやすく淀む　⑤価値観の違う人を排除する　⑥不摂生で不健康・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、「いい加減」「メンタル危なそう」「無神経」と思われます。';
      }
      if (weakness === '15') {
        document.getElementById('weakness-title').innerHTML = '悪魔<br>(THE DEVIL)';
        document.getElementById('weakness-image').src = 'image/bk/15.png';
        document.getElementById('weakness-short-text').innerHTML = '人間の「闇」「グレーゾーン」を集めた究極の悪魔';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・自堕落、誘惑に溺れる、欲望のコントロールができない、執着心が強い、打算的、不摂生な生活をする、人を束縛する、メンタルが弱い、悪い人間と別れられない、悪い習慣から抜け出せない・・・です。言いたいことが言えず、自分を縛りすぎて抑圧する人もいます。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「だらしない」「メンヘラ」と思われます。';
      }
      if (weakness === '16') {
        document.getElementById('weakness-title').innerHTML = '塔<br>(THE TOWER)';
        document.getElementById('weakness-image').src = 'image/bk/16.png';
        document.getElementById('weakness-short-text').innerHTML = 'すべて自分の力だと勘違い、奢り高ぶった天狗人間';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・自分自身の奢り、初心を忘れた言動や行い、感謝のなさ・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「天狗になっている」と思われます。。';
      }
      if (weakness === '17') {
        document.getElementById('weakness-title').innerHTML = '星<br>(THE STAR)';
        document.getElementById('weakness-image').src = 'image/bk/17.png';
        document.getElementById('weakness-short-text').innerHTML = '高すぎる理想を掲げて心折れる、ハリボテのスター';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・理想が高すぎて夢を諦めがち、高望みして心折れる、美しくない世の中に幻滅する、理想どおりにならない現実に失望する・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「理想ばかり語ってついていけない」と思われます。';
      }
      if (weakness === '18') {
        document.getElementById('weakness-title').innerHTML = '月<br>(THE MOON)';
        document.getElementById('weakness-image').src = 'image/bk/18.png';
        document.getElementById('weakness-short-text').innerHTML = '未熟な浄化でさらなる闇へ、不完全なヒーラー';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素は・・・疑心暗鬼、人を信じられない、自分の本心が分からない、自分に嘘をつく、迷い出すと抜けられない、答えが見つからないことに言い知れぬ不安を感じる・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「病んでる」と思われます。';
      }
      if (weakness === '19') {
        document.getElementById('weakness-title').innerHTML = '太陽<br>(THE SUN)';
        document.getElementById('weakness-image').src = 'image/bk/19.png';
        document.getElementById('weakness-short-text').innerHTML = 'ワガママで不平不満、またはガサツで空気を読まない裸の大将';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、忖度しないと言えば聞こえはいいが気遣いや配慮が足りない、ストレートすぎる表現や態度。もうひとつは、不平不満が多い、ワガママ、人を妬む、失敗をバネにできない・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「おおざっぱでガサツ」「ワガママで嫉妬深い」と思われます。';
      }
      if (weakness === '20') {
        document.getElementById('weakness-title').innerHTML = '審判<br>(JUDGEMENT)';
        document.getElementById('weakness-image').src = 'image/bk/20.png';
        document.getElementById('weakness-short-text').innerHTML = '立ちはだかる壁から逃げて自分に向き合わない、臆病な魂の求道者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、過去の出来事を後悔している、引きずっている。もうひとつは、過去の出来事をなかったことにして無視している、過去の出来事を違う解釈で捉えて魂が違和感を覚えている・・・です。どちらも自分自身に向き合っていないという共通項があります。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「痛々しくて見てられない」「本当の自分を生きていない」と思われます。';
      }
      if (weakness === '21') {
        document.getElementById('weakness-title').innerHTML = '世界<br>(THE WORLD)';
        document.getElementById('weakness-image').src = 'image/bk/21.png';
        document.getElementById('weakness-short-text').innerHTML = '完璧主義でピリピリ、気持ちが切れてダラダラ。ワンネスとは程遠い自称成功者';
        document.getElementById('weakness-long-text').innerHTML = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、中途半端でハッキリしない、気持ちが切れるとダラダラして放置する、途中まではいくが未完成、口だけ達者で最後は投げ出す。もうひとつは、ピリピリとした完璧主義、ひとりよがりでワンマン、気持ちに余裕がなくて器が小さい・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「完璧主義で当たりがキツイ」「どこにでもいい顔して結局中途半端」と思われます。';
      }
    
      if (weakness === '19,10') {
        document.getElementById('second-weakness-section').style.display = 'block';
        document.getElementById('weakness-title').innerText = '運命の輪';
          document.getElementById('weakness-image').src = 'image/bk/10.png';
          document.getElementById('weakness-short-text').innerText = '時間感覚がズレている…波に乗れない先駆者';
          document.getElementById('weakness-long-text').innerText = 'あなたが天命に生きることを邪魔している要素は・・・時間感覚が人と違う（遅刻魔）、タイミングを外している感覚、流れに乗れていない、チャンスを掴めない、実力はあるはずなのに芽が出ない、考えすぎると負のループから抜けられない・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「時間にルーズ」「約束を守れない」「言うことがコロコロ変わる」と思われます。';
          document.getElementById('second-weakness-title').innerText = '太陽';
          document.getElementById('second-weakness-image').src = 'image/bk/19.png';
          document.getElementById('second-weakness-short-text').innerText = 'ワガママで不平不満、またはガサツで空気を読まない裸の大将';
          document.getElementById('second-weakness-long-text').innerText = 'あなたが天命に生きることを邪魔している要素が２パターンあります。ひとつは、忖度しないと言えば聞こえはいいが気遣いや配慮が足りない、ストレートすぎる表現や態度。もうひとつは、不平不満が多い、ワガママ、人を妬む、失敗をバネにできない・・・です。ひとつでも当てはまれば、天命を邪魔しています。また、弱点が悪く出れば出るほど、人から「おおざっぱでガサツ」「ワガママで嫉妬深い」と思われます。';
      }
        } 
          
  })
