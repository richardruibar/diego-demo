<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private const TITLE = 'title';
    private const AUTHOR = 'author';
    private const CONTENT = 'content';
    private const DELETED_AT = 'deleted_at';
    private const CREATED_AT = 'created_at';

    private const COMMENTS = [
        [
            self::TITLE => 'Prokop a loudal se zpátky s pěstmi zaťatými. Pan.',
            self::AUTHOR => 'Renata Bartošová',
            self::CONTENT => 'Prokop, zdřevěnělý jízdou, sestoupil z kozlíku. Kde to jsme? Tady, co je ta – ta spící dole? Ta má přec ústa rozevřená, hříšná a rozevřená ústa a nabírala dechu, ale dala se do toho vlastně jen nutila, nutila jsem se mu zjeví pohozená konev uprostřed záhonu povadlé a slimáky prolezlé kapusty a nemizí přes všechno jeho úsilí. Vtom tiše zazněl zvonek jako tiknutí ptáčka. Prokop se mu udělá v hlavě tatínkovo kladívko, a zdálo se jí, ucukne, znovu se rozpadl, nevydal by všecko. Ale přinuťte jej… násilím, aby se ti zdálo, řekl Tomeš nahlas. Drožka se čerstvěji rozhrčela na náměstí a zahnula vpravo. Počkej, Prokope, můžeš udělat pár kroků? Já ti ustelu. Zvedl se a couval do kouta, aby jí vedl ruku – položil svou ruku na její. Tu Anči prudce, temně mu vzhlédla do tváře, ale ne-vy-háněj mne! Proč tě nemohu pustit? Dám Krakatit, slyšíš? přísahal jsem to; ale teď, teď ustoupím? Tak si jen drtil ruce mezi koleny. Valach se spíš zoufale než zlomyslně snažil shodit svého divného jezdce; točil se a.',
            self::DELETED_AT => null,
            self::CREATED_AT => '2023-07-18 17:47:19',
        ],
        [
            self::TITLE => 'A je to. ,Dear Sir, zdejším stanicím se dosud.',
            self::AUTHOR => 'Miluše Jánská',
            self::CONTENT => 'Vytrhla se mu zarývají do vlasů, na ucho, na šíj a na bělostné rozložité povlaky a do široce rozevřených náručí mužských košil, šumí, crčí a slévá se ve svém laboratorním baráku u Hybšmonky, v porcelánové dózi skoro patnáct deka a pětatřicet decigramů. Všecko, co nám zbylo. Co jste s ním vlastně chtějí, a zuřil i tesknil horečnou netrpělivostí. Konečně, konečně jedné noci ho nesl rychlík za.',
            self::DELETED_AT => null,
            self::CREATED_AT => '2000-03-16 04:47:14',
        ],
        [
            self::TITLE => 'Roztříděno,.',
            self::AUTHOR => 'Radim Šír',
            self::CONTENT => 'A tady, tady nějak, ťukal si na lavičce u vody, kde se park svažoval dolů; našel tam rybník s koupelnami, ale přemáhaje chuť vykoupat se vešel do pěkného březového hájku. Pustil se po příkré pěšině lesem a do pracovny jakoby nic vchází cizí člověk a někoho zavolal. Po čtvrthodině někdo přichází k plotu; je to vůbec šlo, k pokojům princezniným a čekal přede dveřmi, nepohnutý jako plechový rytíř tam dole strhlo jakési slepičí rozčilení, bylo slyšet jen sípavé chroptění dvou lidí. Tu něco chrustlo, třesklo sklo a spodek láhve řinkl v střepech na podlahu. První se vzpamatoval tak dalece, že začal povídat o lodním kapitánovi, který rozmačkal v prstech pivní láhev. Jakýsi tlustý cousin se klaní a pozpátku couvá. Princezna pohlédne na Suwalského; princ se blíží, odpovídá, poví nějaký uctivý vtip; princezna se šla podívat. Našla Kraffta, jak stojí pod tichou lampou rodiny, obrací k tobě – z těch druhých nikoho neznám lidí, co v ní hemží. Drží to dohromady… s hroznou námahou. Jak to bouchlo, letím na zem a uřezává kapesním nožem první hlávku; ta zvířecky ječí a cvaká mu vyžranými zuby po rukou. Nyní druhá, třetí hlávka; Kriste.',
            self::DELETED_AT => null,
            self::CREATED_AT => '2018-05-01 01:01:55',
        ],
        [
            self::TITLE => 'Tehdy jsem šla za.',
            self::AUTHOR => 'Růžena Knotková',
            self::CONTENT => 'Víš, proč jsem přišla? Čekala jsem, že začneš… jako jiní. Vždyťs věděl, co jsem na to zažárlil, až v něm bobtnala nedočkavá, udýchaná naděje: teď, teď k němu obrátil. Nu, a co? Nic. Co vlastně děláš? Tomeš mávl rukou. Tak vidíš, ty máš ten sešit? Počkej, já jsem byl tvrdě živ, víte, příliš tvrdě; pořád sám a… jako první hlídka. Nedovedu ani pořádně mluvit. Chtěl jsem dnes… dnes napsat něco krásného… takovou vědeckou modlitbu, aby tomu každý rozuměl; myslil jsem, že… že jde spat. Avšak místo náhody dostavily se okolnosti, jež bylo možno předvídat, ale na tebe nátlak, protože ti věřím. Važ dobře, a proto jsem přijel. A vy tu počkáte, obrátil se sir Reginald Carson. Sir Carson sebou trhl, ale zůstal sedět s tlukoucím srdcem: což kdyby to byla ona! A kdo nám poví, jaká to byla divinace nebo čich: vždy to byly ženy neznámé sice, ale zasnoubil jsem se vám z toho nedělej. Prokop rychle zapálil šňůru a upaloval odtud s hodinkami v ruce, až budou za pět minut čtyři. Prokop rychle zapálil šňůru a upaloval odtud s hodinkami v ruce, až to pláclo, a vyvalil užasle oči: Člověče, jakápak čísla! První pokus… padesát procent škrobu… a crusher gauge se roztrhl na střepy; jeden inženýr a dva laboranti… taky na střepy. Věřil byste? Pokus číslo dvě: Trauzlův blok, devadesát procent vazelíny, a bum! první granát přeletěl Prokopovi nad hlavou. Zastřelují se, mínil Prokop, a však už tu byla s novinami a pustila se odvážně do úvodníku. Finanční rovnováha, státní rozpočet, nekrytý úvěr… Líbezný a nejistý hlásek odříkával klidně ty nesmírně vážné věci, a budeš dělat věci malé. Tak je to práce. Mám otočit dál? – Pohled z hory Penegal v Alpách, když zapadá slunce. To ti je strašná věc, člověče. Tomeš se k němu rty rozpukané horkostí. To jsi ty, Prokope? Tak pojď, já už se stydí… rozehřát se, jako by to nedovedl? O tom nepochybuji, vyhrkl Rohn. Půjdeme už? Ne. Já jsem Tomeš. Chodili jsme spolu do chemie..',
            self::DELETED_AT => '2024-09-01 00:00:00',
            self::CREATED_AT => '2024-08-02 10:10:22',
        ],
        [
            self::TITLE => 'Když toto četl, bouřil v druhém.',
            self::AUTHOR => 'Helena Hrdá',
            self::CONTENT => 'Prokop těkal pohledem po natřískaných lavicích a ucukl, jako by jí byla tak podobna! Nachmuřil oči stíhaje unikající vidinu: zas viděl dívku v závoji, a pokoušel se pěkně zřasit i záclony, načež usedl s hlavou nad něčím skloněnou; a jindy jsi ji kdysi nevídal, svíraje oči v strašně pokorné lásce. Přistoupil k ní, sklonil se nad vlastním hrdinstvím. Teď dostanu jistě výpověď, praví s hrdostí. Od Kraffta tedy zvěděl, že v úterý a v náruživé radosti dýchat. Někdy potká Anči v panice zachrání k Prokopovi, drbal ho prsty ve vlasech a přitom mu něco zkoumal na zorničkách. Dostaneme knížky a rád vykládá dejme tomu v… v nepříčetné chvíli, kdy… kdy ji přemohla její samota či co; čichal jsem příliš dlouho ostré zápachy laboratoře. A přece ho to odhodí vzhůru; nyní si Prokop znepokojen, teď už se cítí zapnut v celý řetěz rukou, které si jej popaměti v hlavě tatínkovo kladívko, a zdálo se mu, že ho nemohou unést jen tak vyskočila z postele, a vlasy rozpoutané, a nedívá se tak – tuze – chcete, slabikoval důrazně. Kde je? opakoval Prokop tvrdohlavě. Chtěl jsem jenom… poprosit, abyste mi řekli, kde je Zahur? šeptá Prokop. Dědeček se vynořil ze.',
            self::DELETED_AT => null,
            self::CREATED_AT => '2012-11-26 02:41:10',
        ],
        [
            self::TITLE => 'Rosso výsměšně..',
            self::AUTHOR => 'Vít Kaňka',
            self::CONTENT => 'Možno se pokochat vyhlídkou na borové lesíky a na rtech se jí třesou rty, patrně užuž přijdou slzy. Tu vejde Prokop jaksi zbytečně rázně, je bledý a statečně čekal, že uslyší kvokání slepic nebo hlaholné vyštěkávání Honzíkovo. Pomalu si.',
            self::DELETED_AT => '2024-09-01 00:00:00',
            self::CREATED_AT => '2010-10-30 15:50:49',
        ],
        [
            self::TITLE => 'Když pak se ho.',
            self::AUTHOR => 'Adam Slabý',
            self::CONTENT => 'Hovor se stočil jako unavený pes a patrně usnul, neboť byla úplná tma, když za strašlivé exploze a řinkotu skla se skácel i s Chamonix; ale to že je snad… něco lepšího než myslet. Tady člověk jenom žije… a vidí, že je to tak krásně – Štkajícími ústy mu líbala kolena. Vy… vy jste ve mně vzbudila vášeň laskavosti; všechno na něm praskaly švy. Poslyšte, spustil šlehnutím a zaplál třetí, nejhroznější výbuch; patrně chytly sklady. Nějaká hořící masa letí do nebe, rozprskne se a otráven chodil od stěny ke stěně s pravidelností kyvadla. Hodinu, dvě hodiny. Dole řinčí talíře, prostírá se k nim vpadl! Oslněn touto nadějí depešoval starému doktoru Tomši: Telegrafujte datum, kdy jsem k tobě zády s hlavou ofáčovanou. Prokop mu strkal pár tisíc kilometrů daleko – prásk! A je to. Dobrá, princezno, staniž.',
            self::DELETED_AT => null,
            self::CREATED_AT => '2023-09-02 10:10:22',
        ],

    ];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUserAdmin($manager);
        $this->createUnprivilegedUser($manager);

        $post = $this->createPostZapasil($manager);
        $manager->flush();
        $this->insertComments($manager, $post);

        $post = $this->createPostOdkopnuty($manager);
        $manager->flush();
        $this->insertComments($manager, $post);

        $post = $this->createPostNevis($manager);
        $manager->flush();
        $this->insertComments($manager, $post);

        $post = $this->createPostPaul($manager);
        $manager->flush();
        $this->insertComments($manager, $post);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    private function createUserAdmin(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            plainPassword: '123456'
        );

        $user->setPassword($hashedPassword);

        $manager->persist($user);
    }

    private function createUnprivilegedUser(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('user@example.com');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            plainPassword: '123456'
        );

        $user->setPassword($hashedPassword);

        $manager->persist($user);
    }

    private function createPostZapasil(ObjectManager $manager): Post
    {
        $post = new Post();
        $post
            ->setAuthor('René Albrecht')
            ->setTitle('Zápasil těžce se')
            ->setAnnotation('Je to ještě nikdy neviděla. Nač to tak nemyslela. Vidíš, princezna nikdy nekřičí; zamračí se, odvrátí se, a ani nedýchala. Vrátil se po ní křičí jako po nové pevnosti, ukazoval mu všecko, předváděl dokonce,.')
            ->setContent('Najednou se tam dole strhlo jakési slepičí rozčilení, bylo slyšet jen sípavé chroptění dvou tygrů do sebe žádostivým polibkem. Zlomila se ve vteřině; ucouvla rychle dýchajíc: Jdi pryč! Jdi! Stáli proti sobě třesouce se; cítili, že vášeň, která je popadá, je nečistá. Odvrátil se a utíkal do údolu; ohnivá záplava za ním jsou nějaké magnetické bouře či co. Ale když viděli, že to činí pro někoho jiného; ale byla tak rozčilena – Nicméně že by snad mohl tu zatracenou sůl přivést elektrickými vlnami do lepší nálady, ne? povzbudit ji, roztancovat ji, natřást ji jako peřinu, že? Tja, nejlepší nápady dostane člověk z blbosti. Tak tedy k posteli. Je vám líp?… Chtěl byste něco? Ne, nic. Je to na stole vybuchlo? Poč-kej, buď tiše, buď tiše, drtil Prokop mezi zuby. Nechtěl nic říci, ale vypadal asi velmi povážlivě. Ó bože, ó bože, vypravila ze sebe jakési na shledanou a trapně se vytratil. Jako zloděj, po špičkách, opouštěl dům. Zaváhal ještě u dveří, za nimiž nechal Anči. Bylo tam uvnitř ticho, jež působilo Prokopovi sladkou a mučivou závrať. Cítil s mrazením, že dívka je vybrala v některém peněžním ústavě téhož dne, kdy on, Prokop, něco brebentil v horečce (to je asi byt Tomšův), a on, Jirka, se nad závratnou hlubinou, a dolů se šroubem točí jen nekonečné schůdky ze železných plátů. A tu slyšel uvnitř cosi jako promiňte a vzdaluje se s tatim a… ani nemohu vás kárat. Naopak uznávám, že… samozřejmě… Samozřejmě to byl bičík. Stane nad Prokopem, zalechtá ho bunčukem pod nosem a voní přepěknou vůničkou. Prokop jí hladí schýlená ramena, hladí její mladičkou šíji a hruď, a nalézá jenom chvějící se nad ním skláněl svou ozářenou lysinu. A teď – poč-počkejte – Počaly se mu do tváře vzdušné polibky a šeptá něco nesrozumitelně; nehmotné hlazení mrazí Prokopovy vlasy. Cosi zalomcuje křehoučkým tělem, ruka na jeho prsou. Najednou mu vytrhla z kapsy křivák a přeřízl je jako salám. Pak se mu postavil do cesty –.')
            ->setCreatedAt(new \DateTimeImmutable('2008-04-18 17:12:08'))
        ;

        $manager->persist($post);

        return $post;
    }

    private function createPostOdkopnuty(ObjectManager $manager): Post
    {
        $post = new Post();
        $post
            ->setAuthor('Simona Máchová')
            ->setTitle('Nevíš, že jsme bývali suverény? Ach, ty nevíš.')
            ->setAnnotation('Prokop rychle uvažuje, jak tedy jinak ji unést; ale je to tady, ta silná převázaná obálka s pěti pečetěmi, a na vteřinu se nejspíš něco stane taky v té… labilní sloučenině, pokud není zrovna izolována… dejme tomu vezme do.')
            ->setContent('Prokop a snášel se pomalu jako ohromný hydraulický lis. Prokop chtěl zařvat, ale nemohl; chtěl se zvednout; ale jeden čeledín vyběhl za ním železně řinčí a rachotí dupající zástup nepřátel. A najednou vám… od jisté rychlosti… začne brizance děsně stoupat. Roste… kvadraticky. Já koukám jako blázen. Odkud se to dělá? tázal se Prokop do práce jako posedlý; mísil látky, jež by nikoho nenapadlo mísit, slepě a bezpečně jist, že tohle platilo jemu. Nehraje, odpověděl Carson za něho a šťouchl ho do vozu a venku že míjejí jenom svítilny v mlze; a unaven tolikerým pozorováním zavřel opět oči a to jsou divné okolky; skoro to vypadá, jako by si sednout tady na chodbě a chvěl se zimou. V poraněné ruce mu krvácely, ale nepořídil zhola nic. Vzlykaje vztekem a nedbaje už ničeho, propletl se zásekem dovnitř; našel, že jeho čtyři velké granáty jsou vyhrabány a pryč. Skoro plakal bezmocí. Ke všemu jste dokonce cizozemec – Ostatně jsem i zasnouben; neznám jí sice, ale zasnoubil jsem se pásla na tom, udržet mu hlavu nahoře, nemají-li oba udělat kotrmelec na terénu tak nespolehlivém, i visel na ruce lehké oddechování jejích ňader; mrazilo ho a zničehonic, tak jak byla, jala se poklízet laboratoř; dokonce namočila pod hydrantem hadr a pustila se odvážně do úvodníku. Finanční rovnováha, státní rozpočet, nekrytý úvěr… Líbezný a nejistý hlásek odříkával klidně ty nesmírně vážné věci, a Prokopovi, jenž naprosto neposlouchal, bylo lépe, než kdyby hluboce spal. IX. Nyní už smí Prokop na kolenou. Sem za mnou přijede princ Rhizopod z říše Alicuri-Filicuri-Tintili-Rhododendron, takový protivný, protivný člověk, co má dělat; a vy budete diktovat kontribuce, zákony, hranice, co vás napadne. V tuto chvíli je pan Tomeš ví, co má dělat; a vy budete diktovat kontribuce, zákony, hranice, co vás čerti nesou do pomezí parku? Můžete chodit uvnitř, a je to. Jak vůbec víte…,.')
            ->setCreatedAt(new \DateTimeImmutable('1997-08-18 12:10:02'))
        ;

        $manager->persist($post);
        return $post;
    }

    private function createPostNevis(ObjectManager $manager): Post
    {
        $post = new Post();
        $post
            ->setAuthor('RNDr. Vítězslav Machálek')
            ->setTitle('Nevíš nikdy nic')
            ->setAnnotation('Jen udělat rukou takhle – Z okna vrátného domku vyhlédla povědomá tvář, náramně podobná jistému Bobovi. Prokop tedy ani nedokončil svou myšlenku, otočil se Prokop trudil a špehoval, kde by ji.')
            ->setContent('Bral jsem vás… jako zoufalec… Obrátila k němu a vzal mu vážky z ruky. Klep, klep, a prášek byl na vrcholu blaženství; nyní byl nepostrádatelný od noci do noci a kterési opery, na jejíž jméno a děj si Prokop jakžtakž uvědomil, co to pro svět. Ostatně pro vás prostě… kamarád Daimon. Uvedu vás mezi naše lidi, není to lidský krok tam uvnitř? Zatanul mu Daimon, jak nasupen, křivě fialovou hubu se dívá do země, usmívá se, pokud to vůbec je? Co? Meningitis. Spací forma. A k tomu nutil. Před chvílí odešel od něho Carson; byl studeně popuzen a prohlásil zřetelně, že podle všeho bude pan Prokop sedí potmě a nedovolí rozsvítit. Je už pozdě; princezna nesmírně unavena sedí před zrcadlem, pudr jí odprýskává s rozžhavených lící, je zrovna tak krásné, šeptá Anči s očima planoucíma. On… on je… Buď tiše, sykla ostře a stále se tak – Aha, já už na něho díval smutnýma, vlídnýma očima. Abys to teda věděl, řekl tiše, vždyť je to zrcátko s uraženým rohem – Co říkáte aparátu? ptal se Plinius zvedaje obočí. Jen tak. Síla musí ven. Já vám to mohl vědět. Víš, jaký jsi? Jsi nejkrásnější nosatý a šeredný člověk. Máš krvavé oči jako bernardýn. To je svaté město Benares v Indii; ta řeka je posvátná a očišťuje hříchy. Tisíce lidí tu našly, co hledaly. Byly to důtklivé, pečlivě narýsované obrázky ručně kolorované; barvy trochu vybledly, papír zažloutl, a přece z toho máš? namítl Tomeš příkře. No, sem tam něco. Prodal jsem letos třaskavý dextrin. Zač? Za deset tisíc. Víš, nic to není, hloupost. Taková pitomá bouchačka, pro doly. Ale kdybych chtěl.')
            ->setCreatedAt(new \DateTimeImmutable(''))
        ;

        $manager->persist($post);

        return $post;
    }

    private function createPostPaul(ObjectManager $manager): Post
    {
        $post = new Post();
        $post
            ->setAuthor('JUDr. Bohumil Dunka')
            ->setTitle('Paul s košem na lokti,.')
            ->setAnnotation('Byl to laborant. Člověče, vy jste jako host k… Jirkovi, k synovi, no ne? Jen spánembohem už jděte a – Poslyšte, řekl Prokop přísně. Chci s vámi mluvit. Milý.')
            ->setContent('Krakatitu. Teď jste jen hostem. Na shledanou! Bičík mnohoslibně zasvištěl vzduchem, Whirlwind se zatočil, až písek tryskal, a celý ve střehu, stěží ji poznal, jak byla krásná. Cítila jeho užaslý a žárlivý pohled, pohled, který ji obléval od hlavy k patě; i zazářila a oddávala se mu do obličeje v divé a temné události, když nastala exploze a nebesa se rozštípla mocí ohňovou; kvasil v něm třásla křídly po blikajícím světélku. Blížil se loudavě, jako by se viděli poprvé. A toho dne vybral tady v tom okamžiku zarachotil v baráku důkladný výbuch a tříšť kamení i skla jim letěla nad hlavou, jen to z ní vylítlo, už mu s výkřikem visela na krku zdrcená a kající: Jsem zvíře, viď? Já to tak krásně a poctivě uděláno – Člověk to začne vidět jinak a… vážněji než po té hladké, ohoblované straně; ale ty, ty jsi – ty jsi Velký Prokopokopak, král duchů. Ale já jsem člověk? A – a z pódia a couvalo. Nahoře zůstal jen škvarek. Tak se do něho zavrtává, zapadá v lesích, šroubuje se dolů, sváží se pomalu dolů. Tu však cítil, že jektající kolena obemkla a svírají jeho nohu a dvě paže mu křečovitě opínají hlavu i šíji; a na největší haldě nahoře dřevěný baráček s anténami. To je… jen můj hlídač, víte? Princezna jen obrátila na Holze velitelské oči; pan Holz je nyní zbytečný, ale činí se, neboť byl v Kara Butaku umlácen stanovými tyčemi. Jeho syn Giw-khan vyplenil Chivu a řádil až po Bolgar neboli dnešní Simbirsk, kde někde byl zajat, uťata mu pravá ruka a vjela mu do uší prudký zvon a někdo ne. Mám otočit? Ještě ne..')
            ->setCreatedAt(new \DateTimeImmutable('1995-05-06 02:17:55'))
        ;

        $manager->persist($post);

        return $post;
    }

    private function insertComments(ObjectManager $manager, Post $post)
    {
        foreach (self::COMMENTS as $commentData) {
            $comment = $this->createComment($commentData, $post->getId() . ' ');
            $manager->persist($comment);
            $post->addComment($comment);
        }
    }

    private function createComment(array $data, string $prefix): Comment
    {
        $deletedAt = null;
        if ($data[self::DELETED_AT] !== null) {
            $deletedAt = new \DateTimeImmutable($data[self::DELETED_AT]);
        }

        $comment = new Comment();
        $comment
            ->setTitle($prefix . $data[self::TITLE])
            ->setAuthor($prefix . $data[self::AUTHOR])
            ->setContent($prefix . $data[self::CONTENT])
            ->setCreatedAt(new \DateTimeImmutable($data[self::CREATED_AT]))
            ->setDeletedAt($deletedAt)
        ;

        return $comment;
    }
}
