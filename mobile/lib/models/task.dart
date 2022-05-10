class TaskModel {
  final String? description, facultyId, title, dueDate;
  final List<StepModel> steps;
  String? uid;

  TaskModel(this.uid, this.title, this.description, this.dueDate,
      this.facultyId, this.steps);

  TaskModel.fromJson(Map<String, dynamic> json)
      : title = json['title'],
        description = json['description'],
        dueDate = json['dueDate'],
        facultyId = json['facultyId'],
        steps = [];
}

class StepModel {
  final String? title, uid;

  StepModel(this.uid, this.title);
}
