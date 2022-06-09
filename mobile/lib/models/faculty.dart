import 'package:erasmus_helper/models/model.dart';

class FacultyModel extends FirebaseModel {
  String cityId;
  String name;
  String code;
  String? id;

  FacultyModel.fromJson(this.id, Map<dynamic, dynamic> json):
      cityId = json["cityId"],
      name = json["name"],
      code = json["code"];

  @override
  Map<String, dynamic> toJson() => {
    "cityId" : cityId,
    "name": name,
    "code": code,
  };
}