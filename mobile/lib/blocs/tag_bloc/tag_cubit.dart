import 'package:erasmus_helper/models/tag.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class TagCubit extends Cubit<List<Tag>> {
  TagCubit(initialState) : super(initialState);

  void add(Tag tag) {
    emit([...state, tag]);
  }

  void remove(Tag tag) {
    List<Tag> newList = List.from(state)
      ..removeWhere((element) => element.title == tag.title);
    emit(newList);
  }

  void addAll(List<Tag> tags) {
    state.addAll(tags);
    emit(state);
  }
}
