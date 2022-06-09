import 'package:erasmus_helper/models/event.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

class EventService {
  /// Return the list of ID events from the same city as the user
  static Future<List<String>?> getIdEventsForUser() async {
    // get the faculty of the current user
    final faculty = await FacultyService.getFacultyById(await FacultyService.getUserFacultyId());
    if (faculty != null) {
      return await getIdEventsByCity(faculty.cityId);
    }
    return null;
  }
  
  static Future<List<String>?> getIdEventsByCity(String cityId) async {
    List<String> eventList = [];
    final DataSnapshot snap = await FirebaseDatabase.instance.ref("events/").orderByChild("cityId").equalTo(cityId).get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        eventList.add(element.key);
      }
    }

    return null;
  }

  static Future<EventModel?> getEventById(String eventId) async {
    final DataSnapshot snap = await FirebaseDatabase.instance.ref("events/$eventId").get();

    if (snap.exists) {
      final json = UtilsService.snapToMap(snap);
      return EventModel.fromJson(eventId, json);
    }
    return null;
  }

  static Future<String> getEventImageURL(String eventId) async {
    return await UtilsService.getImageURL("events", eventId);
  }
}