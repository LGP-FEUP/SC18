import 'package:erasmus_helper/models/model.dart';

class CultureEntry extends FirebaseModel {
  final String uid, title, description, location;
  final List categoryIds;

  CultureEntry(
      this.uid, this.title, this.description, this.location, this.categoryIds);

  CultureEntry.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        location = json['location'],
        categoryIds = (json['categories'] as Map).keys.toList();

  @override
  Map<String, dynamic> toJson() => {
        'title': title,
        'description': description,
        'location': location,
        'categories': categoryIds.map((e) => {e: true})
      };
}

final aux1 = CultureEntry(
    "assets/aux1.png",
    "Palácio de Cristal",
    "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
    "R. de Dom Manuel II",
    [0, 4]);

final aux2 = CultureEntry(
    "assets/4.png",
    "Museu de Serralves",
    "O projeto do Museu de Serralves, da autoria do arquiteto Álvaro Siza, teve início em 1991. Em 1999, foi inaugurado o novo edifício, harmoniosamente integrado na envolvente urbana e nos espaços preexistentes dos jardins, do Parque e da Casa de Serralves. Além das exposições patentes, o visitante do Museu de Serralves descobre as particularidades dos espaços que compõem esta obra arquitetónica dotada da versatilidade e capacidade de transformação indispensáveis para dar resposta à diversidade e à imprevisibilidade da arte contemporânea aqui exposta.",
    "R. Dom João de Castro 210",
    [0, 2]);

final aux3 = CultureEntry(
    "assets/2.png",
    "FitnessUp",
    "Estávamos em 2012 quando juntamos uma equipa humilde a um sonho gigantesco de ser uma versão ﬁtness do mundo Walt Disney.Para complicar queríamos oferecer ao mercado uma versão prestige de clubes low-cost: ecológicos, energizantes, para iniciantes e para proﬁssionais e onde cada um paga apenas aquilo que utiliza. Tudo isto porque acreditamos, mesmo, que Ser Feliz através do Fitness é um direito de todos.Na altura, não estávamos sozinhos! Ainda assim, aqueles que nos eram mais próximos diziam que éramos loucos e que não iríamos sobreviver. Hoje, contamos com vários clubes em várias cidades, e muitos outros já estão a caminho!Continuamos a apostar em clubes com design de excelência, para clientes de bom gosto, clubes bem equipados e, claro, sempre com um sorriso genuíno para receber os nossos amigos. Sim, amigos! Pois se estão a ajudar-nos neste sonho, são nossos amigos!",
    "Estr. da Circunvalação 7316",
    [0, 3]);

final aux4 = CultureEntry(
    "assets/1.png",
    "Brasão Cervejaria",
    "A famosa iguaria do Porto, pode ser comparada a futebol e política: toda a gente tem uma opinião a dar sobre onde comer a melhor, quais os melhores ingredientes, qual o melhor molho. E nunca ninguém está errado, porque realmente é um prato bastante pessoal. Não há nenhuma receita original.",
    "R. de Ramalho Ortigão 28",
    [0, 1]);

final aux5 = CultureEntry(
    "assets/3.png",
    "E-learning Café Asprela",
    "O E-Learning Café da Asprela é um espaço amplo para estudar e ponto de encontro de amigos e colegas. Acessível a todos os membros da comunidade académica (Ensino Superior). Oferece serviços, como: Requisição de equipamentos; Máquinas de venda automática;Mesas e Cadeiras para Estudos",
    "R. Alfredo Allen 535",
    [0, 5]);

final entries = [aux1, aux2, aux3, aux4, aux5];
