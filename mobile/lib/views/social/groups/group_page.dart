import 'package:erasmus_helper/views/social/components/forum_post.dart';
import 'package:flutter/material.dart';
import 'package:flutterfire_ui/database.dart';

import '../../../models/post.dart';
import '../../../services/group_service.dart';
import '../../app_topbar.dart';

class GroupPage extends StatefulWidget {
  final String groupId;
  const GroupPage({Key? key, required this.groupId}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _GroupPageState();
  }
}

class _GroupPageState extends State<GroupPage> {

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: Future.wait([
          GroupService.getGroupImage(widget.groupId),
          GroupService.getGroupTitle(widget.groupId)
        ]),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              List data = response.data as List;
              String image = data[0].toString();
              String title = data[1].toString();

              return AppTopBar(
                  activateBackButton: true,
                  title: "Forum",
                  body: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [_genCover(image, title), _genPostsList()]));
            }
            return Container();
          }
          return Container();
        });
  }

  Widget _genCover(String image, String title) {
    return Stack(children: <Widget>[
      Container(
        decoration: BoxDecoration(
            image: DecorationImage(
                image: NetworkImage(
                    image),
                fit: BoxFit.cover)),
        height: 170.0,
      ),
      _genTitle(title),
    ]);
  }

  Widget _genTitle(String title) {
    final gradient = BoxDecoration(
      gradient: LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: <Color>[
          Colors.black.withAlpha(0),
          Colors.black26,
          Colors.black87
        ],
      ),
    );

    return Container(
      height: 170,
      alignment: Alignment.bottomLeft,
      decoration: gradient,
      child: Padding(
        padding: const EdgeInsets.all(5),
        child: Text(
          title,
          style: const TextStyle(color: Colors.white, fontSize: 20.0),
        ),
      ),
    );
  }

  Widget _genPostsList() {
    return FirebaseDatabaseListView(
      query: GroupService.queryGroupPosts(widget.groupId),
      scrollDirection: Axis.vertical,
      shrinkWrap: true,
      itemBuilder: (context, snapshot) {
        Map<String, dynamic> value = (snapshot.value as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value));
        PostModel post = PostModel.fromJson(snapshot.key.toString(), value);
        return ForumPost(post: post);
      },
    );
  }
}

// ForumPost(post: posts[index])
