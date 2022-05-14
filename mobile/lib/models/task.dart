import '../services/utils_service.dart';

class TaskModel {
  final String uid, description, facultyId, title, dueDate;
  final int when;
  bool done;
  List<StepModel> steps = [];

  TaskModel(this.uid, this.title, this.description, this.dueDate,
      this.facultyId, this.done, this.when);

  TaskModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        dueDate = json['due_date'],
        facultyId = json['faculty_id'],
        when = json['when'],
        done = false {
    List<StepModel> stepsList = [];
    if (json["steps"] != null) {
      for (var element
          in UtilsService.dynamicToMapOfMap(json["steps"]).entries) {
        stepsList.add(StepModel.fromJson(element.key, element.value));
      }
    }
    steps = stepsList;
  }
}

class StepModel {
  final String title, uid;
  bool done;

  StepModel(this.uid, this.title, this.done);

  StepModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        done = false;
}
