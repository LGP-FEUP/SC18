import 'package:erasmus_helper/models/model.dart';

class TaskModel extends model{
  final String uid, description, title;
  final DateTime dueDate;
  final String when;
  bool done;
  List<StepModel> steps = [];

  TaskModel(this.uid, this.title, this.description, this.dueDate, this.done,
      this.when);

  TaskModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        dueDate = DateTime.parse(json['due_date']["date"]),
        when = json['when'],
        done = false {
    List<StepModel> stepsList = [];
    if (json["steps"] != null) {
      for (var element in json["steps"]) {
        // dynamic elem = UtilsService.dynamicToMapOfMap(element);
        stepsList.add(StepModel.fromJson(element["id"], element as Map));
      }
    }
    steps = stepsList;
  }

  Map<String, dynamic> toJson() {
    // TODO: implement toJson
    throw UnimplementedError();
  }
}

class StepModel extends model{
  final String title, uid;
  bool done;

  StepModel(this.uid, this.title, this.done);

  StepModel.fromJson(this.uid, Map json)
      : title = json['name'],
        done = false;

  @override
  Map<String, dynamic> toJson() {
    // TODO: implement toJson
    throw UnimplementedError();
  }
}
