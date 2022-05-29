/// Abstract class for all firebase models, currently used to have an automatically generated toString().
/// Would be nice to add automatic json generation in it (if possible)
/// TODO : add default toJson()
abstract class FirebaseModel {
  FirebaseModel();
  Map<String, dynamic> toJson();
  FirebaseModel.fromJson(Map<dynamic, dynamic> json);
  @override
  String toString() {
    return toJson().toString();
  }
}