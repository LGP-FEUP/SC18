class TaskModel {
  final String uid, description, facultyId, title, dueDate;
  bool done;
  List<StepModel> steps = [];

  TaskModel(this.uid, this.title, this.description, this.dueDate,
      this.facultyId, this.done);

  TaskModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        dueDate = json['due_date'],
        facultyId = json['faculty_id'],
        steps = json["steps"] != null
            ? StepModel.listFromJson(json["steps"] as Map<dynamic, dynamic>)
            : [],
        done = false;

  static TaskModel fromJsonMap(MapEntry<dynamic, dynamic> json) {
    var t = TaskModel.fromJson(
        json.key.toString(),
        (json.value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value)));

    return t;
  }

  static List<TaskModel> listFromJson(Map<dynamic, dynamic> json) {
    List<TaskModel> steps = [];

    for (var element in json.entries) {
      steps.add(TaskModel.fromJsonMap(element));
    }

    return steps;
  }
}

class StepModel {
  final String title, uid;
  bool done;

  StepModel(this.uid, this.title, this.done);

  StepModel.fromJson(this.uid, Map<String, dynamic> json)
      : title = json['title'],
        done = false;

  static StepModel fromJsonMap(MapEntry<dynamic, dynamic> json) {
    return StepModel.fromJson(
        json.key.toString(),
        (json.value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value)));
  }

  static List<StepModel> listFromJson(Map<dynamic, dynamic> json) {
    List<StepModel> steps = [];

    for (var element in json.entries) {
      steps.add(StepModel.fromJsonMap(element));
    }

    return steps;
  }
}
