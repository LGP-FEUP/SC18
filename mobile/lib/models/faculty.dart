import 'package:erasmus_helper/models/model.dart';

class FacultyModel extends FirebaseModel {
  String cityId;
  String name;
  String code;
  String? id;

  FacultyModel.fromJson(this.id, Map<dynamic, dynamic> json):
      cityId = json["city_id"],
      name = json["name"],
      code = json["code"];

  @override
  Map<String, dynamic> toJson() => {
    "city_id" : cityId,
    "name": name,
    "code": code,
  };
}