import 'package:erasmus_helper/models/event.dart';
import 'package:erasmus_helper/services/event_service.dart';
import 'package:flutter/material.dart';

class EventCard extends StatelessWidget {
  final String eventId;

  const EventCard({Key? key, required this.eventId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.wait([
        EventService.getEventById(eventId),
        EventService.getEventImageURL(eventId)
      ]),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            List data = response.data as List;
            EventModel? event = data[0];
            String imageURL = data[1];
            if (event != null) {
              String title = event.title;
              return genCard(imageURL, title);
            }
          }
        }
        return Container();
      },
    );
  }

  Widget genCard(String imageURL, String title) {
    return Card(
      elevation: 3,
      child: Stack(
        alignment: Alignment.topCenter,
        children: [
          Row(
            children: [genEventImage(imageURL)],
          ),
          Positioned(top: 150, child: Row(children: [genEventInfo(title)]))
        ],
      ),
    );
  }

  Widget genEventImage(String imageURL) {
    return Container(
      height: 170,
      width: 252,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(5),
        image: DecorationImage(
          fit: BoxFit.fill,
          //TODO: change to Network Image
          image: Image.network(imageURL).image,
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
