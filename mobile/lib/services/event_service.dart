import 'package:erasmus_helper/models/event.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';

class EventService {
  static Future<List<EventModel>> getEventsByCity(String cityId) async {
    List<EventModel> eventList = [];
    final DataSnapshot snap = await FirebaseDatabase.instance.ref("events/$cityId").get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        eventList.add(EventModel.fromJson(element.key, element.value));
      }
    }

    return eventList;
  }
}