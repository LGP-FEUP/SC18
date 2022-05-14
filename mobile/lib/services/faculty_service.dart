import 'package:erasmus_helper/services/user_service.dart';
import 'package:firebase_database/firebase_database.dart';

class FacultyService {
  static String collectionName = "faculties/";

  static Future<Map<String, String>> getFacultiesNames() async {
    final DataSnapshot snap =
        await FirebaseDatabase.instance.ref(collectionName).get();
    final Map map = snap.value as Map<dynamic, dynamic>;

    return map.map((key, value) => MapEntry(
        (value as Map<dynamic, dynamic>)["name"].toString(), key.toString()));
  }

  static Future<String> getUserFacultyId() async {
    final DataSnapshot snap = await UserService.getUserRef()
        .child("faculty_arriving_id")
        .get();

    return snap.value.toString();
  }
}
