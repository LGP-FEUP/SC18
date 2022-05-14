import 'package:firebase_database/firebase_database.dart';

class UtilsService {
  static Map<String, dynamic> snapToMap(DataSnapshot snap) {
    return (snap.value as Map<dynamic, dynamic>)
        .map((key, value) => MapEntry(key.toString(), value));
  }

  static Map<String, Map<String, dynamic>> snapToMapOfMap(DataSnapshot snap) {
    return (snap.value as Map<dynamic, dynamic>).map((key, value) => MapEntry(
        key.toString(),
        (value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value))));
  }

  static Map<String, Map<String, dynamic>> dynamicToMapOfMap(dynamic obj) {
    return (obj as Map<dynamic, dynamic>).map((key, value) => MapEntry(
        key.toString(),
        (value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value))));
  }
}
