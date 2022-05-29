import 'package:erasmus_helper/models/post.dart';
import 'package:erasmus_helper/services/group_service.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:erasmus_helper/views/social/groups/components/group_post.dart';
import 'package:flutter/material.dart';
import 'package:flutterfire_ui/database.dart';
import 'add_post_page.dart';

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
                  floatingButton: FloatingActionButton(
                      onPressed: _navigateToAddPostPage,
                      child: const Icon(Icons.add)),
                  activateBackButton: true,
                  title: "$title Group",
                  body: Column(
                    children: [
                      _genCover(image, title),
                      Expanded(child: _genPostsList())
                    ],
                  ));
            }
            return const Center(
              child: Text('No data for group'),
            );
          }
          return const Center(
            child: CircularProgressIndicator(),
          );
        });
  }

  Widget _genCover(String image, String title) {
    return Stack(children: <Widget>[
      Container(
        decoration: BoxDecoration(
            image:
                DecorationImage(image: NetworkImage(image), fit: BoxFit.cover)),
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
    return FirebaseDatabaseQueryBuilder(
      query: GroupService.queryGroupPosts(widget.groupId),
      builder: (context, snapshot, _) {
        if (snapshot.isFetching) {
          return const Center(
            child: CircularProgressIndicator(),
            heightFactor: 10,
          );
        }

        if (snapshot.hasError) {
          return Center(
            child: Text('Something went wrong! ${snapshot.error}'),
            heightFactor: 10,
          );
        }

        return snapshot.docs.isNotEmpty
            ? ListView.builder(
                padding: const EdgeInsets.symmetric(vertical: 10),
                scrollDirection: Axis.vertical,
                shrinkWrap: true,
                itemCount: snapshot.docs.length,
                itemBuilder: (context, index) {
                  // obtain more items
                  if (snapshot.hasMore && index + 1 == snapshot.docs.length) {
                    snapshot.fetchMore();
                  }

                  Map<String, dynamic> value =
                      (snapshot.docs[index].value as Map<dynamic, dynamic>)
                          .map((key, value) => MapEntry(key.toString(), value));
                  PostModel post = PostModel.fromJson(
                      snapshot.docs[index].key.toString(), value);

                  return GroupPost(post: post);
                },
              )
            : const Center(
                child: Text("This group has no activity yet."),
                heightFactor: 10,
              );
      },
    );
  }

  void _navigateToAddPostPage() {
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => AddPostPage(groupId: widget.groupId)));
  }
}

// ForumPost(post: posts[index])
