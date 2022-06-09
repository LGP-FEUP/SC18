import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

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

  /// Return a map of the selected children with their values, used to access only
  /// the wanted values (in case of rules restrictions)
  ///
  /// ```dart
  /// Map<String, dynamic> map = await UtilsService.mapOfRefChildren(ref, ["firstname",
  ///   "lastname", "interests", "faculty_origin_id", "faculty_arriving_id",
  ///   "description", "country_code", "phone", "whatsapp", "facebook"]);
  /// return UserModel.fromProfileJson(map);
  /// ```
  static Future<Map<String, dynamic>> mapOfRefChildren(DatabaseReference ref, List<String> childrenNames) async {
    List<DataSnapshot> snaps = [];
    Map<String, dynamic> map = {};
    for (var name in childrenNames) {
      snaps.add(await ref.child(name).get());
    }
    for (var snap in snaps) {
      if (snap.exists) {
        if (snap.key != null && snap.value != null) {
          map.addEntries(
              [MapEntry(snap.key as String, snap.value as dynamic)]
          );
        }
      }
    }
    return map;
  }

  /// Used to get the URL of an image in the firebase cloud.
  /// If the name is null or the image is not found, it will return the default
  /// image inside the path file.
  ///
  /// ```dart
  ///   final imageURL = getImageURL("events/", event.id);
  /// or
  ///   final imageURL = getImageURL("events", event.id);
  /// ```
  static Future<String> getImageURL(String path, String? name) async {
    // If there is a missing / at the end of path
    if (path[path.length - 1] != '/') {
      path += '/';
    }
    final defaultImage = FirebaseStorage.instance.ref(path+"default.png");
    if (name != null) {
      try {
        return await FirebaseStorage.instance.ref(path+name).getDownloadURL();
      } catch (e) {
        return await defaultImage.getDownloadURL();
      }
    }
    return await defaultImage.getDownloadURL();
  }
}
