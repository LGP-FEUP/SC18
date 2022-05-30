import 'package:flutter/material.dart';

class EventCard extends StatelessWidget {
  final String eventId;

  const EventCard({Key? key, required this.eventId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.wait([
        //TODO: fetch events from firebase
        Future<String>.value("assets/event_default.jpg"),
        Future<String>.value("Surfing Trip!!!")
      ]),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            List data = response.data as List;
            String image = data[0].toString();
            String title = data[1].toString();
            return genCard(image, title);
          }
        }
        return Container();
      },
    );
  }

  Widget genCard(String image, String title) {
    return Card(
      elevation: 3,
      child: Stack(
        alignment: Alignment.topCenter,
        children: [
          Row(
            children: [genEventImage(image)],
          ),
          Positioned(top: 150, child: Row(children: [genEventInfo(title)]))
        ],
      ),
    );
  }

  Widget genEventImage(String image) {
    return Container(
      height: 170,
      width: 252,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(5),
        image: DecorationImage(
          fit: BoxFit.fill,
          //TODO: change to Network Image
          image: AssetImage(
            image,
          ),
        ),
      ),
    );
  }

  Widget genEventInfo(String title) {
    return Container(
        width: 252,
        height: 50,
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(5), color: Colors.white),
        alignment: Alignment.centerLeft,
        child: Padding(
          padding: const EdgeInsets.only(left: 5),
          child: Text(title,
              textAlign: TextAlign.end,
              style:
                  const TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
        ));
  }
}
